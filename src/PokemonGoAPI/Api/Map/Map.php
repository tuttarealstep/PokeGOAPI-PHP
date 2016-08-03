<?php
/**
 * User: tuttarealstep
 * Date: 27/07/16
 * Time: 22.00
 */

namespace PokemonGoAPI\Api\Map;

use POGOProtos\Map\Fort\FortType;
use POGOProtos\Networking\Requests\Messages\FortDetailsMessage;
use POGOProtos\Networking\Requests\Messages\GetMapObjectsMessage;
use POGOProtos\Networking\Requests\RequestType;
use POGOProtos\Networking\Responses\FortDetailsResponse;
use POGOProtos\Networking\Responses\GetMapObjectsResponse;
use PokemonGoAPI\Api\Gym\Gym;
use PokemonGoAPI\Api\Map\Fort\FortDetails;
use PokemonGoAPI\Api\Map\Fort\Pokestop;
use PokemonGoAPI\Api\Map\Pokemon\CatchablePokemon;
use PokemonGoAPI\Api\Map\Pokemon\NearbyPokemon;
use PokemonGoAPI\Api\PokemonGoAPI;
use PokemonGoAPI\Google\Common\Geometry\S2Cell;
use PokemonGoAPI\Google\Common\Geometry\S2CellId;
use PokemonGoAPI\Google\Common\Geometry\S2LatLng;
use PokemonGoAPI\Main\ServerRequest;

/**
 * Class Map
 * @package PokemonGoAPI\Api\Map
 */
class Map
{
    const CELL_WIDTH = 3;
    const RESEND_REQUEST = 5000;

    /**
     * @var null|PokemonGoAPI
     */
    private $pokemonGoAPI = null;

    /**
     * @var bool
     */
    private $useCache;

    /**
     * @var MapObjects
     */
    private $cachedMapObjects;

    /**
     * @var
     */
    private $mapObjectsExpiry;

    /**
     * @var int
     */
    private $lastMapUpdate;

    /**
     * Map constructor.
     * @param PokemonGoAPI $pokemonGoAPI
     */
    function __construct(PokemonGoAPI $pokemonGoAPI)
    {
        $this->pokemonGoAPI = $pokemonGoAPI;
        $this->cachedMapObjects = new MapObjects($pokemonGoAPI);
        $this->lastMapUpdate = 0;
        $this->useCache = true;
    }


    public function clearCache() {
        $this->lastMapUpdate = 0;
        $this->cachedMapObjects = new MapObjects($this->pokemonGoAPI);
    }

    /**
     * @return CatchablePokemon[]
     */
    public function getCatchablePokemon()
    {
        $catchablePokemons = [];
        $objects = $this->getMapObjects();

        foreach($objects->getCatchablePokemons() as $mapPokemon)
        {
            $catchablePokemons[$mapPokemon->getEncounterId()] = new CatchablePokemon($this->pokemonGoAPI, $mapPokemon);
        }

        foreach($objects->getWildPokemons() as $wildPokemon)
        {
            $catchablePokemons[$wildPokemon->getEncounterId()] = new CatchablePokemon($this->pokemonGoAPI, null, $wildPokemon);
        }



        return $catchablePokemons;
    }

    /**
     * @return NearbyPokemon[]
     */
    public function getNearbyPokemon()
    {
        $pokemons = [];
		$objects = $this->getMapObjects();

		foreach ($objects->getNearbyPokemons() as $pokemon) {
            $pokemons[] = new NearbyPokemon($pokemon);
        }

		return $pokemons;
    }

    /**
     * @return Point[]
     */
    public function getSpawnPoints()
    {
        $points = [];
		$objects = $this->getMapObjects();

		foreach ($objects->getSpawnPoints() as $point) {
            $points[] = new Point(null, null, $point);
        }

		return $points;
    }

    /**
     * @return Gym[]
     */
    public function getGyms()
    {
        $gyms = [];
		$objects = $this->getMapObjects();
		foreach ($objects->getGyms() as $fortdata) {
            $gyms[] = new Gym($this->pokemonGoAPI, $fortdata);
        }

		return $gyms;
    }

    /**
     * @return Pokestop[]
     */
    public function getPokestops()
    {
        $stops = [];
        $objects = $this->getMapObjects();
        foreach ($objects->getPokestops() as $fortdata) {
            $stops[] = $fortdata;
        }

        return $stops;
    }

    /**
     * @return Point
     */
    public function getDecimatedSpawnPoints()
    {
        $points = [];
        $objects = $this->getMapObjects();

        foreach ($objects->getDecimatedSpawnPoints() as $point) {
            $points[] = new Point($point);
        }

        return $points;
    }

    /**
     * @param int $width
     * @return MapObjects
     */
    public function getMapObjects($width = 9)
    {
        return $this->getMapObjectsCells($this->getCellIds($this->pokemonGoAPI->getLatitude(), $this->pokemonGoAPI->getLongitude(), $width), $this->pokemonGoAPI->getLatitude(), $this->pokemonGoAPI->getLongitude(), $this->pokemonGoAPI->getAltitude());
    }

    /**
     * @param $cellIds
     * @param $latitude
     * @param $longitude
     * @param $altitude
     * @return MapObjects
     */
    public function getMapObjectsCells($cellIds, $latitude, $longitude, $altitude)
    {
        $this->pokemonGoAPI->setLatitude((float) $latitude);
        $this->pokemonGoAPI->setLongitude((float) $longitude);
        $this->pokemonGoAPI->setAltitude((float) $altitude);

		if ($this->useCache && ($this->pokemonGoAPI->currentTimeMillis() - $this->lastMapUpdate > $this->mapObjectsExpiry)) {
            $this->lastMapUpdate = 0;
            $this->cachedMapObjects = new MapObjects($this->pokemonGoAPI);
        }

		$builder = new GetMapObjectsMessage();
        $builder->setLatitude((float) $this->pokemonGoAPI->getLatitude());
        $builder->setLongitude((float) $this->pokemonGoAPI->getLongitude());

        $index = 0;
		foreach ($cellIds as $cellId)
        {
            $builder->addCellId($cellId);
			$builder->addSinceTimestampMs($this->lastMapUpdate);
            $index++;
		}

		$serverRequest = new ServerRequest(RequestType::GET_MAP_OBJECTS, $builder);
		$this->pokemonGoAPI->getRequestHandler()->sendServerRequests($serverRequest);
		$response = new GetMapObjectsResponse($serverRequest->getData());
		$result = new MapObjects($this->pokemonGoAPI);
		foreach ($response->getMapCellsArray() as $mapCell) {
            $result->addNearbyPokemons($mapCell->getNearbyPokemonsArray());
            $result->addCatchablePokemons($mapCell->getCatchablePokemonsArray());
            $result->addWildPokemons($mapCell->getWildPokemonsArray());
            $result->addDecimatedSpawnPoints($mapCell->getDecimatedSpawnPointsArray());
            $result->addSpawnPoints($mapCell->getSpawnPointsArray());

            foreach($mapCell->getFortsArray() as $fort)
            {
                if($fort->getType() == FortType::GYM)
                {
                    $result->addGyms($fort);
                } elseif($fort->getType() == FortType::CHECKPOINT) {
                    $result->addPokestops($fort);
                }
            }
		}

		if ($this->useCache) {
            $this->cachedMapObjects->update($result);
            $result = $this->cachedMapObjects;
            $this->lastMapUpdate = $this->pokemonGoAPI->currentTimeMillis();
        }

		return $result;
    }

    /**
     * @param $latitude
     * @param $longitude
     * @param $width
     * @return array
     */
    public function getCellIds( $latitude, $longitude, $width)
    {
        $latLng = S2LatLng::fromDegrees($latitude, $longitude);
        $cellId = S2CellId::fromLatLng($latLng)->parent(15);

		$index = 0;
		$jindex = 0;


		$level = $cellId->level();
		$size = 1 << (S2CellId::MAX_LEVEL - $level);
		$face = $cellId->toFaceIJOrientation($index, $jindex);

		$cells = [];

		$halfWidth = floor($width / 2);
		for ($x = - $halfWidth; $x <= $halfWidth; $x++) {
            for ($y = - $halfWidth; $y <= $halfWidth; $y++) {
                $cells[] = S2CellId::fromFaceIJ($face, $index + $x * $size, $jindex + $y * $size)->parent(15)->id();
            }
		}
		return $cells;
    }

    /**
     * @param $id
     * @param $lon
     * @param $lat
     * @return FortDetails
     */
    public function getFortDetails($id, $lon, $lat)
    {
        $reqMsg = new FortDetailsMessage();
        $reqMsg->setFortId($id);
        $reqMsg->setLatitude($lat);
        $reqMsg->setLongitude($lon);

		$serverRequest = new ServerRequest(RequestType::FORT_DETAILS, $reqMsg);
		$this->pokemonGoAPI->getRequestHandler()->sendServerRequests($serverRequest);
		$response = new FortDetailsResponse($serverRequest->getData());

		return new FortDetails($response);
    }

    /**
     * @return MapObjects
     */
    public function getCachedMapObjects()
    {
        return $this->cachedMapObjects;
    }

    /**
     * @return mixed
     */
    public function getMapObjectsExpiry()
    {
        return $this->mapObjectsExpiry;
    }

    /**
     * @param $cachedMapObjects
     */
    public function setCachedMapObjects($cachedMapObjects)
    {
        $this->cachedMapObjects = $cachedMapObjects;
    }

    /**
     * @param $mapObjectsExpiry
     */
    public function setMapObjectsExpiry($mapObjectsExpiry)
    {
        $this->mapObjectsExpiry = $mapObjectsExpiry;
    }
}