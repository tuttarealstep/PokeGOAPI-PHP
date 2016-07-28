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

    function __construct(PokemonGoAPI $pokemonGoAPI, FortData $fortData)
    {
        $this->pokemonGoAPI = $pokemonGoAPI;
        $this->fortData = $fortData;
    }

    public function getId()
    {
        return $this->fortData->getId();
    }

    public function getLatitude()
    {
		return $this->fortData->getLatitude();
	}

	public function getLongitude()
    {
		return $this->fortData->getLongitude();
	}

	public function getEnabled()
    {
		return $this->fortData->getEnabled();
	}

	public function getOwnedByTeam()
    {
		return $this->fortData->getOwnedByTeam();
	}

	public function getGuardPokemonId()
    {
		return $this->fortData->getGuardPokemonId();
	}

	public function getGuardPokemonCp()
    {
		return $this->fortData->getGuardPokemonCp();
	}

	public function getPoints()
    {
		return $this->fortData->getGymPoints();
	}

	public function getIsInBattle()
    {
		return $this->fortData->getIsInBattle();
	}

	public function isAttackable()
    {
        return (count($this->getGymMembers()) != 0);
    }

	public function battle($team)
    {
        return new Battle($this->pokemonGoAPI, $team, $this);
    }

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

    public function getName()
    {
        return $this->details()->getName();
    }

	public function getUrlsList()
    {
        return $this->details()->getUrlsArray();
    }

	public function getResult()
    {
        return $this->details()->getResult();
    }

	public function inRange()
    {
        $result = $this->getResult();
		return ( $result != GetGymDetailsResponse_Result::ERROR_NOT_IN_RANGE);
	}

	public function getDescription() {
        return $this->details()->getDescription();
    }

	public function getGymMembers() {
        return $this->details()->getGymState()->getMembershipsArray();
    }

	public function getDefendingPokemon() {
        $data = [];

		foreach ($this->getGymMembers() as $gymMember) {
            $data[] = $gymMember->getPokemonData();
        }

		return $data;
	}

	protected function getApi() {
		return $this->pokemonGoAPI;
	}

}