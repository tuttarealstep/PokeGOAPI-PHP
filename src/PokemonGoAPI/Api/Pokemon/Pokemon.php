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

	/**
	 * Pokemon constructor.
	 * @param PokemonGoAPI $pokemonGoAPI
	 * @param PokemonData $pokemonData
	 */
    function __construct(PokemonGoAPI $pokemonGoAPI, PokemonData $pokemonData)
    {
        $this->pokemonGoAPI = $pokemonGoAPI;
        $this->pokemonData = $pokemonData;
    }

	/**
	 * @return int
	 */
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

	/**
	 * @param $newName
	 * @return int
	 */
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

	/**
	 * @return int
	 */
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

	/**
	 * @return EvolutionResult
	 */
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

	/**
	 * @return mixed|null
	 */
    public function getMeta()
    {
        if($this->pokemonMeta == null)
        {
            $this->pokemonMeta = PokemonMetaRegistry::getMeta($this->getPokemonId());
        }

        return $this->pokemonMeta;
    }

	/**
	 * @return int
	 */
    public function getCandy() {
        return $this->pokemonGoAPI->getInventories()->getCandyjar()->getCandies($this->getPokemonFamily());
    }

	/**
	 * @return mixed
	 */
    public function getPokemonFamily() {
		return PokemonMetaRegistry::getFamily($this->getPokemonId());
	}

	/**
	 * @param $other
	 * @return bool
	 */
	public function equals($other) {
        return ($other->getId() == $this->getId());
    }

	/**
	 * @return mixed
	 */
	public function getDefaultInstanceForType() {
		return $this->pokemonData->getDefaultInstanceForType();
	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->pokemonData->getId();
	}

	/**
	 * @return int
	 */
	public function getPokemonId() {
		return $this->pokemonData->getPokemonId();
	}

	/**
	 * @return int
	 */
	public function getCp() {
		return $this->pokemonData->getCp();
	}

	/**
	 * @return int
	 */
	public function getStamina() {
		return $this->pokemonData->getStamina();
	}

	/**
	 * @return int
	 */
	public function getMaxStamina() {
		return $this->pokemonData->getStaminaMax();
	}

	/**
	 * @return int
	 */
	public function getMove1() {
		return $this->pokemonData->getMove1();
	}

	/**
	 * @return int
	 */
	public function getMove2() {
		return $this->pokemonData->getMove2();
	}

	/**
	 * @return string
	 */
	public function getDeployedFortId() {
		return $this->pokemonData->getDeployedFortId();
	}

	/**
	 * @return string
	 */
	public function getOwnerName() {
		return $this->pokemonData->getOwnerName();
	}

	/**
	 * @return bool
	 */
	public function getIsEgg() {
		return $this->pokemonData->getIsEgg();
	}

	/**
	 * @return int
	 */
	public function getEggKmWalkedTarget() {
		return $this->pokemonData->getEggKmWalkedTarget();
	}

	/**
	 * @return int
	 */
	public function getEggKmWalkedStart() {
		return $this->pokemonData->getEggKmWalkedStart();
	}

	/**
	 * @return int
	 */
	public function getOrigin() {
		return $this->pokemonData->getOrigin();
	}

	/**
	 * @return int
	 */
	public function getHeightM() {
		return $this->pokemonData->getHeightM();
	}

	/**
	 * @return int
	 */
	public function getIndividualAttack() {
		return $this->pokemonData->getIndividualAttack();
	}

	/**
	 * @return int
	 */
	public function getIndividualDefense() {
		return $this->pokemonData->getIndividualDefense();
	}

	/**
	 * @return int
	 */
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

	/**
	 * @return int
	 */
	public function getCpMultiplier() {
		return $this->pokemonData->getCpMultiplier();
	}

	/**
	 * @return int
	 */
	public function getPokeball() {
		return $this->pokemonData->getPokeball();
	}

	/**
	 * @return int
	 */
	public function getCapturedS2CellId() {
		return $this->pokemonData->getCapturedCellId();
	}

	/**
	 * @return int
	 */
	public function getBattlesAttacked() {
		return $this->pokemonData->getBattlesAttacked();
	}

	/**
	 * @return int
	 */
	public function getBattlesDefended() {
		return $this->pokemonData->getBattlesDefended();
	}

	/**
	 * @return string
	 */
	public function getEggIncubatorId() {
		return $this->pokemonData->getEggIncubatorId();
	}

	/**
	 * @return int
	 */
	public function getCreationTimeMs() {
		return $this->pokemonData->getCreationTimeMs();
	}

	/**
	 * @return bool
	 */
	public function getFavorite() {
		return $this->pokemonData->getFavorite() > 0;
	}

	/**
	 * @return string
	 */
	public function getNickname() {
		return $this->pokemonData->getNickname();
	}

	/**
	 * @return bool
	 */
	public function getFromFort() {
		return $this->pokemonData->getFromFort() > 0;
	}

	public function debug() {
        $this->pokemonGoAPI->getOutput()->write($this->pokemonData->toString());
	}

	/**
	 * @return mixed
	 */
	public function getBaseStam() {
		return $this->getMeta()->getBaseStam();
	}

	/**
	 * @return mixed
	 */
	public function getBaseCaptureRate() {
		return $this->getMeta()->getBaseCaptureRate();
	}

	/**
	 * @return mixed
	 */
	public function getCandiesToEvolve() {
		return $this->getMeta()->getCandiesToEvolve();
	}

	/**
	 * @return mixed
	 */
	public function getBaseFleeRate() {
		return $this->getMeta()->getBaseFleeRate();
	}

	/**
	 * @return mixed
	 */
	public function getParent() {
		return $this->getMeta()->getParent();
	}
}