<?php
/**
 * User: tuttarealstep
 * Date: 27/07/16
 * Time: 20.42
 */

namespace PokemonGoAPI\Api\Inventory;

use POGOProtos\Networking\Requests\Messages\UseItemEggIncubatorMessage;
use POGOProtos\Networking\Requests\RequestType;
use POGOProtos\Networking\Responses\ReleasePokemonResponse_Result;
use POGOProtos\Networking\Responses\UseItemEggIncubatorResponse;
use PokemonGoAPI\Api\Pokemon\EggPokemon;
use PokemonGoAPI\Api\PokemonGoAPI;
use PokemonGoAPI\Main\ServerRequest;

class EggIncubator
{
    private $PokemonGoAPI = null;
    private $EggIncubator = null;

    /**
     * EggIncubator constructor.
     * @param PokemonGoAPI $pokemonGoAPI
     * @param \POGOProtos\Inventory\EggIncubator $EggIncubator
     */
    function __construct(PokemonGoAPI $pokemonGoAPI, \POGOProtos\Inventory\EggIncubator $EggIncubator)
    {
        $this->PokemonGoAPI = $pokemonGoAPI;
        $this->EggIncubator = $EggIncubator;
    }

    /**
     * Return the remaining uses
     *
     * @return int
     */
    public function getUsesRemaining()
    {
        return $this->EggIncubator->getUsesRemaining();
    }

    /**
     * Return current hatched egg
     *
     * @param EggPokemon $egg
     * @return int
     */
    public function hatchEgg(EggPokemon $egg)
    {
        $requestMessage = new UseItemEggIncubatorMessage();
        $requestMessage->setItemId($this->EggIncubator->getId());
        $requestMessage->setPokemonId($egg->getId());

        $serverRequest = new ServerRequest(RequestType::USE_ITEM_EGG_INCUBATOR, $requestMessage);
        $this->PokemonGoAPI->getRequestHandler()->sendServerRequests($serverRequest);

        $response = new UseItemEggIncubatorResponse($serverRequest->getData());
        $this->PokemonGoAPI->getInventories()->updateInventories(true);

        return $response->getResult();
    }

    /**
     * Return the eggincubator id
     *
     * @return string
     */
    public function getId() {
        return $this->EggIncubator->getId();
    }

    /**
     * Return the type of the incubator
     *
     * @return int
     */
    public function getType() {
		return $this->EggIncubator->getIncubatorType();
	}

    /**
     * @return int
     */
	public function getKmTarget() {
		return $this->EggIncubator->getTargetKmWalked();
	}

    /**
     * Return the km walked
     *
     * @return int
     */
	public function getKmWalked() {
		return $this->EggIncubator->getStartKmWalked();
	}

    /**
     * Return true if the incubator is in use
     *
     * @return bool
     */
	public function isInUse() {
		return $this->getKmTarget() > $this->PokemonGoAPI->getPlayerProfile()->getStats()->getKmWalked();
	}
}