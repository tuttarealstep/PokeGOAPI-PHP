<?php
/**
 * User: tuttarealstep
 * Date: 25/07/16
 * Time: 23.31
 */

namespace PokemonGoAPI\Api\Pokemon;

use POGOProtos\Data\PokemonData;
use POGOProtos\Networking\Requests\Messages\EvolvePokemonMessage;
use POGOProtos\Networking\Requests\Messages\NicknamePokemonMessage;
use POGOProtos\Networking\Requests\Messages\ReleasePokemonMessage;
use POGOProtos\Networking\Requests\Messages\UpgradePokemonMessage;
use POGOProtos\Networking\Requests\RequestType;
use POGOProtos\Networking\Responses\EvolvePokemonResponse;
use POGOProtos\Networking\Responses\NicknamePokemonResponse;
use POGOProtos\Networking\Responses\ReleasePokemonResponse;
use POGOProtos\Networking\Responses\ReleasePokemonResponse_Result;
use POGOProtos\Networking\Responses\UpgradePokemonResponse;
use PokemonGoAPI\Api\Map\Pokemon\EvolutionResult;
use PokemonGoAPI\Api\PokemonGoAPI;
use PokemonGoAPI\Main\ServerRequest;

class Pokemon
{
    private $pokemonGoAPI = null;
    private $pokemonData = null;
    private $pokemonMeta = null;

    function __construct(PokemonGoAPI $pokemonGoAPI, PokemonData $pokemonData)
    {
        $this->pokemonGoAPI = $pokemonGoAPI;
        $this->pokemonData = $pokemonData;
    }

    public function transferPokemon()
    {
        $requestMessage = new ReleasePokemonMessage();
        $requestMessage->setPokemonId($this->getId());

        $serverRequest = new ServerRequest(RequestType::RELEASE_POKEMON, $requestMessage);
        $this->pokemonGoAPI->getRequestHandler()->sendServerRequests($serverRequest);

        $response = new ReleasePokemonResponse($serverRequest->getData());

        if ($response->getResult() == ReleasePokemonResponse_Result::SUCCESS) {
            $this->pokemonGoAPI->getInventories()->getPokebank()->removePokemon($this);
        }

        //$this->pokemonGoAPI->getInventories()->getPokebank()->removePokemon($this);

        $this->pokemonGoAPI->getInventories()->updateInventories();

        return $response->getResult();
    }

    public function renamePokemon($newName)
    {
        $requestMessage = new NicknamePokemonMessage();
        $requestMessage->setPokemonId($this->getId());
        $requestMessage->setNickname($newName);

        $serverRequest = new ServerRequest(RequestType::NICKNAME_POKEMON, $requestMessage);
        $this->pokemonGoAPI->getRequestHandler()->sendServerRequests($serverRequest);

        $response = new NicknamePokemonResponse($serverRequest->getData());

        $this->pokemonGoAPI->getInventories()->getPokebank()->removePokemon($this);
        $this->pokemonGoAPI->getInventories()->updateInventories(false);

        return $response->getResult();
    }

    public function powerUp()
    {
        $requestMessage = new UpgradePokemonMessage();
        $requestMessage->setPokemonId($this->getId());

        $serverRequest = new ServerRequest(RequestType::UPGRADE_POKEMON, $requestMessage);
        $this->pokemonGoAPI->getRequestHandler()->sendServerRequests($serverRequest);

        $response = new UpgradePokemonResponse($serverRequest->getData());

        $this->pokemonData = $response->getUpgradedPokemon();

        return $response->getResult();
    }

    public function evolve()
    {
        $requestMessage = new EvolvePokemonMessage();
        $requestMessage->setPokemonId($this->getId());

        $serverRequest = new ServerRequest(RequestType::EVOLVE_POKEMON, $requestMessage);
        $this->pokemonGoAPI->getRequestHandler()->sendServerRequests($serverRequest);

        $response = new EvolvePokemonResponse($serverRequest->getData());

        $result = new EvolutionResult($this->pokemonGoAPI, $response);

        $this->pokemonGoAPI->getInventories()->getPokebank()->removePokemon($this);
        $this->pokemonGoAPI->getInventories()->updateInventories(false);

        return $result;
    }

    public function getMeta()
    {
        if($this->pokemonMeta == null)
        {
            $this->pokemonMeta = PokemonMetaRegistry::getMeta($this->getPokemonId());
        }

        return $this->pokemonMeta;
    }

    public function getCandy() {
        return $this->pokemonGoAPI->getInventories()->getCandyjar()->getCandies($this->getPokemonFamily());
    }

    public function getPokemonFamily() {
		return PokemonMetaRegistry::getFamily($this->getPokemonId());
	}

	public function equals($other) {
        return ($other->getId() == $this->getId());
    }

	public function getDefaultInstanceForType() {
		return $this->pokemonData->getDefaultInstanceForType();
	}

	public function getId() {
		return $this->pokemonData->getId();
	}

	public function getPokemonId() {
		return $this->pokemonData->getPokemonId();
	}

	public function getCp() {
		return $this->pokemonData->getCp();
	}

	public function getStamina() {
		return $this->pokemonData->getStamina();
	}

	public function getMaxStamina() {
		return $this->pokemonData->getStaminaMax();
	}

	public function getMove1() {
		return $this->pokemonData->getMove1();
	}

	public function getMove2() {
		return $this->pokemonData->getMove2();
	}

	public function getDeployedFortId() {
		return $this->pokemonData->getDeployedFortId();
	}

	public function getOwnerName() {
		return $this->pokemonData->getOwnerName();
	}

	public function getIsEgg() {
		return $this->pokemonData->getIsEgg();
	}

	public function getEggKmWalkedTarget() {
		return $this->pokemonData->getEggKmWalkedTarget();
	}

	public function getEggKmWalkedStart() {
		return $this->pokemonData->getEggKmWalkedStart();
	}

	public function getOrigin() {
		return $this->pokemonData->getOrigin();
	}

	public function getHeightM() {
		return $this->pokemonData->getHeightM();
	}

	public function getIndividualAttack() {
		return $this->pokemonData->getIndividualAttack();
	}

	public function getIndividualDefense() {
		return $this->pokemonData->getIndividualDefense();
	}

	public function getIndividualStamina() {
		return $this->pokemonData->getIndividualStamina();
	}

	/**
     * Calculates the pokemons IV ratio.
     * @return the pokemons IV ratio as a double between 0 and 1.0, 1.0 being perfect IVs
     */
	public function getIVRatio() {
		return ($this->getIndividualAttack() + $this->getIndividualDefense() + $this->getIndividualStamina()) / 45.0;
	}

	public function getCpMultiplier() {
		return $this->pokemonData->getCpMultiplier();
	}

	public function getPokeball() {
		return $this->pokemonData->getPokeball();
	}

	public function getCapturedS2CellId() {
		return $this->pokemonData->getCapturedCellId();
	}

	public function getBattlesAttacked() {
		return $this->pokemonData->getBattlesAttacked();
	}

	public function getBattlesDefended() {
		return $this->pokemonData->getBattlesDefended();
	}

	public function getEggIncubatorId() {
		return $this->pokemonData->getEggIncubatorId();
	}

	public function getCreationTimeMs() {
		return $this->pokemonData->getCreationTimeMs();
	}

	public function getFavorite() {
		return $this->pokemonData->getFavorite() > 0;
	}

	public function getNickname() {
		return $this->pokemonData->getNickname();
	}

	public function getFromFort() {
		return $this->pokemonData->getFromFort() > 0;
	}

	public function debug() {
        $this->pokemonGoAPI->getOutput()->write($this->pokemonData->toString());
	}

	public function getBaseStam() {
		return $this->getMeta()->getBaseStam();
	}

	public function getBaseCaptureRate() {
		return $this->getMeta()->getBaseCaptureRate();
	}

	public function getCandiesToEvolve() {
		return $this->getMeta()->getCandiesToEvolve();
	}

	public function getBaseFleeRate() {
		return $this->getMeta()->getBaseFleeRate();
	}

	public function getParent() {
		return $this->getMeta()->getParent();
	}
}