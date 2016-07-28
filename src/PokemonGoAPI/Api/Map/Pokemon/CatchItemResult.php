<?php
/**
 * User: tuttarealstep
 * Date: 28/07/16
 * Time: 14.36
 */

namespace PokemonGoAPI\Api\Map\Pokemon;

use POGOProtos\Networking\Responses\UseItemCaptureResponse;

class CatchItemResult
{

    private $response;

    function __construct(UseItemCaptureResponse $response) {
        $this->response = $response;
    }

    public function getSuccess() {
		return  $this->response->getSuccess();
	}

	public function getItemCaptureMult() {
		return  $this->response->getItemCaptureMult();
	}

	public function getItemFleeMult() {
		return  $this->response->getItemFleeMult();
	}

	public function getStopMovement() {
		return  $this->response->getStopMovement();
	}

	public function getStopAttack() {
		return  $this->response->getStopAttack();
	}

	public function getTargetMax() {
		return  $this->response->getTargetMax();
	}

	public function getTargetSlow() {
		return  $this->response->getTargetSlow();
	}
}