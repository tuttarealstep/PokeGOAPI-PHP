<?php
/**
 * User: tuttarealstep
 * Date: 28/07/16
 * Time: 12.53
 */

namespace PokemonGoAPI\Api\Map\Pokemon;

use POGOProtos\Networking\Responses\CatchPokemonResponse;
use POGOProtos\Networking\Responses\CatchPokemonResponse_CatchStatus;

class CatchResult
{
    private $failed = false;
    private $captureAward;
    private $response;

    function __construct(CatchPokemonResponse $response = null)
    {
        if($response != null)
        {
            $this->captureAward = $response->getCaptureAward();
            $this->response = $response;
        } else {
            $this->setFailed(false);
        }
    }

    public function setFailed($failed)
    {
        $this->failed = $failed;
    }

    public function getStatus() 
    {
        return $this->response->getStatus();
    }

    public function getMissPercent() {
		return $this->response->getMissPercent();
	}

	public function getCapturedPokemonId() {
		return $this->response->getCapturedPokemonId();
	}

	public function getActivityTypeList() {
		return $this->captureAward->getActivityTypeArray();
	}

	public function getXpList() {
		return $this->captureAward->getXpArray();
	}

	public function getCandyList() {
		return $this->captureAward->getCandyArray();
	}

	public function getStardustList() {
		return $this->captureAward->getStardustArray();
	}

	public function isFailed() {
		if ($this->response == null) {
            return $this->failed;
        }
		return ($this->getStatus() != CatchPokemonResponse_CatchStatus::CATCH_SUCCESS || $this->failed);
	}
}