<?php
/**
 * User: tuttarealstep
 * Date: 27/07/16
 * Time: 22.00
 */

namespace PokemonGoAPI\Api\Map;

use POGOProtos\Networking\Requests\Messages\GetMapObjectsMessage;
use POGOProtos\Networking\Requests\RequestType;
use PokemonGoAPI\Api\PokemonGoAPI;
use PokemonGoAPI\Main\ServerRequest;

class Map
{
    private $pokemonGoAPI = null;

    private $useCache;
    private $cachedMapObjects;
    private $mapObjectsExpiry;

    private $lastMapUpdate;

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

    public function getCatchablePokemon()
    {
        $catchablePokemons = [];
        $objects = $this->getMapObjects();

        foreach($objects->getCatchablePokemons() as $mapPokemon)
        {
            $catchablePokemons[] = new CatchablePokemon($this->pokemonGoAPI, $mapPokemon);
        }
    }

    public function getMapObjects($width = 9)
    {
        return $this->getMapObjectsCells($this->getCellIds($this->pokemonGoAPI->getAltitude(), $this->pokemonGoAPI->getLongitude(), $width), $this->pokemonGoAPI->getLatitude(), $this->pokemonGoAPI->getLongitude(), $this->pokemonGoAPI->getAltitude());
    }

    public function getMapObjectsCells($cellIds)
    {
        //TODO Missing GetMapObjectsResponse
       /* $builder = new GetMapObjectsMessage();

		if ($this->useCache && ($this->pokemonGoAPI->currentTimeMillis() - $this->lastMapUpdate > $this->mapObjectsExpiry)) {
            $this->lastMapUpdate = 0;
            $this->cachedMapObjects = new MapObjects($this->pokemonGoAPI);
        }

		$builder = new GetMapObjectsMessage();
        $builder->setLatitude($this->pokemonGoAPI->getLatitude());
        $builder->setLongitude($this->pokemonGoAPI->getLongitude());

		$index = 0;
		foreach ($cellIds as $cellId) {
            $builder->addCellId($cellId);
			$builder->addSinceTimestampMs([$this->lastMapUpdate]);
			$index++;
		}

		$serverRequest = new ServerRequest(RequestType::GET_MAP_OBJECTS, $builder);
		$this->pokemonGoAPI->getRequestHandler()->sendServerRequests($serverRequest);
		$response = new GetMapObjectsResponse($serverRequest->getData());

		$result = new MapObjects($this->pokemonGoAPI);
		foreach ($response->getMapCellsList() as $mapCell) {
            $result->addNearbyPokemons($mapCell->getNearbyPokemonsList());
            $result->addCatchablePokemons($mapCell->getCatchablePokemonsList());
            $result->addWildPokemons($mapCell->getWildPokemonsList());
            $result->addDecimatedSpawnPoints($mapCell->getDecimatedSpawnPointsList());
            $result->addSpawnPoints($mapCell->getSpawnPointsList());


			$result.addGyms(groupedForts.get(FortType.GYM));
			$result.addPokestops(groupedForts.get(FortType.CHECKPOINT));
		}

		if ($this->useCache) {
            $this->cachedMapObjects->update($result);
            $result = $this->cachedMapObjects;
            $lastMapUpdate = $this->pokemonGoAPI->currentTimeMillis();
        }

		return $result;*/
    }

    public function getCellIds($latitude, $longitude, $width)
    {
        //TODO google.common.geometry
    }

    public function getFortDetails($id, $lon, $lat)
    {
        //TODO missing FortDetailsResponse
    }

    public function getCachedMapObjects()
    {
        return $this->cachedMapObjects;
    }

    public function getMapObjectsExpiry()
    {
        return $this->mapObjectsExpiry;
    }

    public function setCachedMapObjects($cachedMapObjects)
    {
        $this->cachedMapObjects = $cachedMapObjects;
    }

    public function setMapObjectsExpiry($mapObjectsExpiry)
    {
        $this->mapObjectsExpiry = $mapObjectsExpiry;
    }
}