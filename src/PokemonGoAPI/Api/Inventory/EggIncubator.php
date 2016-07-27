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

    function __construct(PokemonGoAPI $pokemonGoAPI, \POGOProtos\Inventory\EggIncubator $EggIncubator)
    {
        $this->PokemonGoAPI = $pokemonGoAPI;
        $this->EggIncubator = $EggIncubator;
    }

    public function getUsesRemaining()
    {
        return $this->EggIncubator->getUsesRemaining();
    }

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

    public function getId() {
        return $this->EggIncubator->getId();
    }

    public function getType() {
		return $this->EggIncubator->getIncubatorType();
	}

	public function getKmTarget() {
		return $this->EggIncubator->getTargetKmWalked();
	}

	public function getKmWalked() {
		return $this->EggIncubator->getStartKmWalked();
	}

	public function isInUse() {
		return $this->getKmTarget() > $this->PokemonGoAPI->getPlayerProfile()->getStats()->getKmWalked();
	}
}