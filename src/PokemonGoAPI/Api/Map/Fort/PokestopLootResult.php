<?php
/**
 * User: tuttarealstep
 * Date: 31/07/16
 * Time: 12.35
 */

namespace PokemonGoAPI\Api\Map\Fort;

use POGOProtos\Networking\Responses\FortSearchResponse;
use POGOProtos\Networking\Responses\FortSearchResponse_Result;

class PokestopLootResult
{
    private $response;

    function __construct(FortSearchResponse $response)
    {
        $this->response = $response;
    }

    public function wasSuccessful() {
        return $this->response->getResult() == FortSearchResponse_Result::SUCCESS || $this->response->getResult() == FortSearchResponse_Result::INVENTORY_FULL;
    }

    public function getResult() {
		return $this->response->getResult();
	}

	public function getItemsAwarded() {
		return $this->response->getItemsAwardedArray();
	}

	public function getExperience() {
		return $this->response->getExperienceAwarded();
	}

	public function toPrimitive() {
		return $this->response;
	}
}