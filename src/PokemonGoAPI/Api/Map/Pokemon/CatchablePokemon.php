<?php
/**
 * User: tuttarealstep
 * Date: 28/07/16
 * Time: 12.00
 */

namespace PokemonGoAPI\Api\Map\Pokemon;

use POGOProtos\Inventory\Item\ItemId;
use POGOProtos\Map\Pokemon\MapPokemon;
use POGOProtos\Map\Pokemon\WildPokemon;
use POGOProtos\Networking\Requests\Messages\CatchPokemonMessage;
use POGOProtos\Networking\Requests\Messages\EncounterMessage;
use POGOProtos\Networking\Requests\Messages\UseItemCaptureMessage;
use POGOProtos\Networking\Requests\RequestType;
use POGOProtos\Networking\Responses\CatchPokemonResponse;
use POGOProtos\Networking\Responses\CatchPokemonResponse_CatchStatus;
use POGOProtos\Networking\Responses\EncounterResponse;
use POGOProtos\Networking\Responses\EncounterResponse_Status;
use POGOProtos\Networking\Responses\UseItemCaptureResponse;
use PokemonGoAPI\Api\Inventory\Pokeball;
use PokemonGoAPI\Api\PokemonGoAPI;
use PokemonGoAPI\Main\ServerRequest;

class CatchablePokemon
{
    private $pokemonGoAPI = null;

    private $spawnPointId;
    private $encounterId;
    private $pokemonId;
    private $expirationTimestampMs;
    private $latitude;
    private $longitude;

    private $encountered = false;


    /**
     * CatchablePokemon constructor.
     * @param PokemonGoAPI $pokemonGoAPI
     * @param MapPokemon|null $MapPokemon
     * @param WildPokemon|null $wildPokemon
     */
    function __construct(PokemonGoAPI $pokemonGoAPI, MapPokemon $MapPokemon = null, WildPokemon $wildPokemon = null)
    {
        $this->pokemonGoAPI = $pokemonGoAPI;

        if($MapPokemon == null)
        {
            if($wildPokemon != null)
            {
                $this->spawnPointId = $wildPokemon->getSpawnPointId();
                $this->encounterId = $wildPokemon->getEncounterId();
                $this->pokemonId = $wildPokemon->getPokemonData()->getPokemonId();
                $this->expirationTimestampMs = $wildPokemon->getTimeTillHiddenMs();
                $this->latitude = $wildPokemon->getLatitude();
                $this->longitude = $wildPokemon->getLongitude();
            }
        } else {
            if($wildPokemon == null)
            {
                $this->spawnPointId = $MapPokemon->getSpawnPointId();
                $this->encounterId = $MapPokemon->getEncounterId();
                $this->pokemonId = $MapPokemon->getPokemonId();
                $this->expirationTimestampMs = $MapPokemon->getExpirationTimestampMs();
                $this->latitude = $MapPokemon->getLatitude();
                $this->longitude = $MapPokemon->getLongitude();
            }
        }
    }

    public function encounterPokemon()
    {

        $reqMsg = new EncounterMessage();
        $reqMsg->setEncounterId($this->getEncounterId());
        $reqMsg->setPlayerLatitude($this->pokemonGoAPI->getLatitude());
        $reqMsg->setPlayerLongitude($this->pokemonGoAPI->getLongitude());
        $reqMsg->setSpawnPointId($this->getSpawnPointId());

		$serverRequest = new ServerRequest(RequestType::ENCOUNTER, $reqMsg);
		$this->pokemonGoAPI->getRequestHandler()->sendServerRequests($serverRequest);

        $response = new EncounterResponse($serverRequest->getData());

		$this->encountered = $response->getStatus() == EncounterResponse_Status::ENCOUNTER_SUCCESS;
		return new EncounterResult($response);
    }

    public function catchPokemonWithRazzBerry()
    {
        $this->useItem(ItemId::ITEM_RAZZ_BERRY);
        return $this->catchPokemonWithPokeballAndAmountAndRazberryLimit($this->getAvaiblePokeball(), -1, -1);
    }

    /**
     * @return int
     * @throws \Exception
     */
    private function getAvaiblePokeball(){
        $bag = $this->pokemonGoAPI->getInventories()->getItemBag();

        if ($bag->getItem(ItemId::ITEM_POKE_BALL)->getCount() > 0) {
            $pokeball = Pokeball::POKEBALL;
        } elseif ($bag->getItem(ItemId::ITEM_GREAT_BALL)->getCount() > 0) {
            $pokeball = Pokeball::GREATBALL;
        } elseif ($bag->getItem(ItemId::ITEM_ULTRA_BALL)->getCount() > 0) {
            $pokeball = Pokeball::ULTRABALL;
        } elseif ($bag->getItem(ItemId::ITEM_ULTRA_BALL)->getCount() > 0) {
            $pokeball = Pokeball::MASTERBALL;
        } else {
            throw new \Exception('Not enough pokeball in bag');
        }

        return $pokeball;
    }

    public function catchPokemon()
    {
        return $this->catchPokemonWithPokeballType($this->getAvaiblePokeball());
    }

    public function catchPokemonWithPokeballType($pokeball)
    {
        return $this->catchPokemonWithPokeballAndAmount($pokeball, -1);
    }

    public function catchPokemonWithPokeballAndAmount($pokeball, $amount)
    {
        return $this->catchPokemonFunction(1.0, 1.95 + (float) rand()/ (float) getrandmax() * 0.5, 0.85 + (float) rand()/ (float) getrandmax() * 0.15, $pokeball, $amount, -1);
    }

    public function catchPokemonWithPokeballAndAmountAndRazberryLimit($pokeball, $amount, $razberryLimit)
    {
        return $this->catchPokemonFunction(1.0, 1.95 + (float) rand()/ (float) getrandmax() * 0.5, 0.85 + (float) rand()/ (float) getrandmax() * 0.15, $pokeball, $amount, $razberryLimit);
    }

    /**
     * @param $normalizedHitPosition
     * @param $normalizedReticleSize
     * @param $spinModifier
     * @param $type
     * @param $amount
     * @param $razberriesLimit
     * @return CatchResult
     */
    public function catchPokemonFunction($normalizedHitPosition, $normalizedReticleSize, $spinModifier, $type, $amount, $razberriesLimit)
    {
        if(!$this->isEncountered())
        {
            return new CatchResult();
        }

        $razberries = 0;
		$numThrows = 0;

		do {

            if ($razberries < $razberriesLimit || $razberriesLimit == -1) {
                $this->useItem(ItemId::ITEM_RAZZ_BERRY);
                $razberries++;
            }

            $reqMsg = new CatchPokemonMessage();
            $reqMsg->setEncounterId($this->getEncounterId());
            $reqMsg->setHitPokemon(true);
            $reqMsg->setNormalizedHitPosition($normalizedHitPosition);
            $reqMsg->setNormalizedReticleSize($normalizedReticleSize);
            $reqMsg->setSpawnPointId($this->getSpawnPointId());
            $reqMsg->setSpinModifier($spinModifier);
            $reqMsg->setPokeball($type);

			$serverRequest = new ServerRequest(RequestType::CATCH_POKEMON, $reqMsg);
            $this->pokemonGoAPI->getRequestHandler()->sendServerRequests($serverRequest);

			$response = new CatchPokemonResponse($serverRequest->getData());

			if ($response->getStatus() != CatchPokemonResponse_CatchStatus::CATCH_ESCAPE
                && $response->getStatus() != CatchPokemonResponse_CatchStatus::CATCH_MISSED) {
                break;
            }
			$numThrows++;
		}
        while ($amount < 0 || $numThrows < $amount);

		$this->pokemonGoAPI->getInventories()->updateInventories(false);

		return new CatchResult($response);
    }

    /**
     * @param $item
     * @return CatchItemResult
     */
    public function useItem($item)
    {
        $reqMsg = new UseItemCaptureMessage();
        $reqMsg->setEncounterId($this->getEncounterId());
        $reqMsg->setSpawnPointId($this->getSpawnPointId());
        $reqMsg->setItemId($item);

		$serverRequest = new ServerRequest(RequestType::USE_ITEM_CAPTURE, $reqMsg);

        $this->pokemonGoAPI->getRequestHandler()->sendServerRequests($serverRequest);

        $response = new UseItemCaptureResponse($serverRequest->getData());

		return new CatchItemResult($response);
    }

    public function getEncounterId()
    {
        return $this->encounterId;
    }

    public function getExpirationTimestampMs()
    {
        return $this->expirationTimestampMs;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function getPokemonId()
    {
        return $this->pokemonId;
    }

    public function getSpawnPointId()
    {
        return $this->spawnPointId;
    }

    public function isEncountered()
    {
        return $this->encountered;
    }
}