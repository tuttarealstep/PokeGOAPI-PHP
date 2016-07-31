<?php
/**
 * User: tuttarealstep
 * Date: 28/07/16
 * Time: 14.57
 */

namespace PokemonGoAPI\Api\Gym;

use POGOProtos\Map\Fort\FortData;
use POGOProtos\Networking\Requests\Messages\GetGymDetailsMessage;
use POGOProtos\Networking\Requests\RequestType;
use POGOProtos\Networking\Responses\GetGymDetailsResponse;
use POGOProtos\Networking\Responses\GetGymDetailsResponse_Result;
use PokemonGoAPI\Api\PokemonGoAPI;
use PokemonGoAPI\Main\ServerRequest;

class Gym
{
    private $fortData = null;
    private $GetGymDetailsResponse = null;
    private $pokemonGoAPI = null;

    /**
     * Gym constructor.
     * @param PokemonGoAPI $pokemonGoAPI
     * @param FortData $fortData
     */
    function __construct(PokemonGoAPI $pokemonGoAPI, FortData $fortData)
    {
        $this->pokemonGoAPI = $pokemonGoAPI;
        $this->fortData = $fortData;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->fortData->getId();
    }

    /**
     * @return int
     */
    public function getLatitude()
    {
		return $this->fortData->getLatitude();
	}

    /**
     * @return int
     */
	public function getLongitude()
    {
		return $this->fortData->getLongitude();
	}

    /**
     * @return bool
     */
	public function getEnabled()
    {
		return $this->fortData->getEnabled();
	}

    /**
     * @return int
     */
	public function getOwnedByTeam()
    {
		return $this->fortData->getOwnedByTeam();
	}

    /**
     * @return int
     */
	public function getGuardPokemonId()
    {
		return $this->fortData->getGuardPokemonId();
	}

    /**
     * @return int
     */
	public function getGuardPokemonCp()
    {
		return $this->fortData->getGuardPokemonCp();
	}

    /**
     * @return int
     */
	public function getPoints()
    {
		return $this->fortData->getGymPoints();
	}

    /**
     * @return bool
     */
	public function getIsInBattle()
    {
		return $this->fortData->getIsInBattle();
	}

    /**
     * @return bool
     */
	public function isAttackable()
    {
        return (count($this->getGymMembers()) != 0);
    }

    /**
     * @param $team
     * @return Battle
     */
	public function battle($team)
    {
        return new Battle($this->pokemonGoAPI, $team, $this);
    }

    /**
     * @return null|GetGymDetailsResponse
     */
    private function details()
    {
        if ($this->GetGymDetailsResponse == null) {
            $reqMsg = new GetGymDetailsMessage();
            $reqMsg->setGymId($this->getId());
            $reqMsg->setGymLatitude($this->getLatitude());
            $reqMsg->setGymLongitude($this->getLongitude());
            $reqMsg->setPlayerLatitude($this->pokemonGoAPI->getLatitude());
            $reqMsg->setPlayerLongitude($this->pokemonGoAPI->getLongitude());


            $serverRequest = new ServerRequest(RequestType::GET_GYM_DETAILS, $reqMsg);
            $this->pokemonGoAPI->getRequestHandler()->sendServerRequests($serverRequest);

            $this->GetGymDetailsResponse = new GetGymDetailsResponse($serverRequest->getData());
        }
            return $this->GetGymDetailsResponse;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->details()->getName();
    }

    /**
     * @return array
     */
	public function getUrlsList()
    {
        return $this->details()->getUrlsArray();
    }

    /**
     * @return int
     */
	public function getResult()
    {
        return $this->details()->getResult();
    }

    /**
     * @return bool
     */
	public function inRange()
    {
        $result = $this->getResult();
		return ( $result != GetGymDetailsResponse_Result::ERROR_NOT_IN_RANGE);
	}

    /**
     * @return string
     */
	public function getDescription()
    {
        return $this->details()->getDescription();
    }

    /**
     * @return mixed
     */
	public function getGymMembers()
    {
        return $this->details()->getGymState()->getMembershipsArray();
    }

    /**
     * @return array
     */
	public function getDefendingPokemon()
    {
        $data = [];

		foreach ($this->getGymMembers() as $gymMember) {
            $data[] = $gymMember->getPokemonData();
        }

		return $data;
	}

    /**
     * @return null|PokemonGoAPI
     */
	protected function getApi()
    {
		return $this->pokemonGoAPI;
	}

}