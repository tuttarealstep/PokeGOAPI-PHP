<?php
/**
 * User: tuttarealstep
 * Date: 28/07/16
 * Time: 12.15
 */

namespace PokemonGoAPI\Api\Map\Pokemon;

use POGOProtos\Networking\Responses\EncounterResponse;
use POGOProtos\Networking\Responses\EncounterResponse_Status;

class EncounterResult
{
    private $response;

    function __construct(EncounterResponse $response)
    {
        $this->response = $response;
    }

    public function getStatus() {
        return $this->response == null ? null : $this->response->getStatus();
    }

    public function wasSuccessful() {
		return  $this->response != null && $this->getStatus() != null && $this->getStatus() == EncounterResponse_Status::ENCOUNTER_SUCCESS;
	}

	public function getBackground() {
		return  $this->response->getBackground();
	}

	public function getCaptureProbability() {
		return  $this->response->getCaptureProbability();
	}

	public function getWildPokemon() {
		return  $this->response->getWildPokemon();
	}

	public function toPrimitive() {
		return $this->response;
	}
}