<?php
/**
 * User: tuttarealstep
 * Date: 31/07/16
 * Time: 12.03
 */

namespace PokemonGoAPI\Api\Map\Fort;

use POGOProtos\Inventory\Item\ItemId;
use POGOProtos\Map\Fort\FortData;
use POGOProtos\Networking\Requests\Messages\AddFortModifierMessage;
use POGOProtos\Networking\Requests\Messages\FortDetailsMessage;
use POGOProtos\Networking\Requests\Messages\FortSearchMessage;
use POGOProtos\Networking\Requests\RequestType;
use POGOProtos\Networking\Responses\AddFortModifierResponse;
use POGOProtos\Networking\Responses\FortDetailsResponse;
use POGOProtos\Networking\Responses\FortSearchResponse;
use PokemonGoAPI\Api\PokemonGoAPI;
use PokemonGoAPI\Google\Common\Geometry\S2LatLng;
use PokemonGoAPI\Main\ServerRequest;

class Pokestop
{
    private $pokemonGoAPI = null;
    private $fortData = null;
    private $cooldownCompleteTimestampMs;


    function __construct(PokemonGoAPI $pokemonGoAPI, FortData $fortData)
    {
        $this->pokemonGoAPI = $pokemonGoAPI;
        $this->fortData = $fortData;
        $this->cooldownCompleteTimestampMs = $fortData->getCooldownCompleteTimestampMs();
    }

    /**
     * Check if is in range
     *
     * @return bool
     */
    public function inRange()
    {
        $pokestop = S2LatLng::fromDegrees($this->getLatitude(), $this->getLongitude());
        $player = S2LatLng::fromDegrees($this->pokemonGoAPI->getLatitude(), $this->pokemonGoAPI->getLongitude());
        $distance = $pokestop->getEarthDistance($player);

        return $distance < 30;
    }

    public function canLoot($ignoreDistance = false)
    {
        $active = $this->cooldownCompleteTimestampMs < $this->pokemonGoAPI->currentTimeMillis();
		if (!$ignoreDistance) {
            return $active && $this->inRange();
        }
		return $active;
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

	/**
     * Loots a pokestop for pokeballs and other items.
     *
     * @return PokestopLootResult
     */
	public function loot()
    {
        $searchMessage = new FortSearchMessage();
        $searchMessage->setFortId($this->getId());
        $searchMessage->setFortLatitude($this->getLatitude());
        $searchMessage->setFortLongitude($this->getLongitude());
        $searchMessage->setPlayerLatitude($this->pokemonGoAPI->getLatitude());
        $searchMessage->setPlayerLongitude($this->getLongitude());

        $serverRequest = new ServerRequest(RequestType::FORT_SEARCH, $searchMessage);
        $this->pokemonGoAPI->getRequestHandler()->sendServerRequests($serverRequest);

        $response = new FortSearchResponse($serverRequest->getData());
        return new PokestopLootResult($response);

    }

    /**
     * Adds a modifier to this pokestop. (i.e. add a lure module)
     *
     * @param $item
     * @return AddFortModifierResponse
     */
	public function addModifier($item) {
        $msg = new AddFortModifierMessage();
        $msg->setModifierType($item);
        $msg->setFortId($this->getId());
        $msg->setPlayerLatitude($this->pokemonGoAPI->getLatitude());
        $msg->setPlayerLongitude($this->pokemonGoAPI->getLongitude());

		$serverRequest = new ServerRequest(RequestType::ADD_FORT_MODIFIER, $msg);

        $this->pokemonGoAPI->getRequestHandler()->sendServerRequests($serverRequest);
        $response = new AddFortModifierResponse($serverRequest->getData());
        return $response;
	}

	/**
     * Get more detailed information about a pokestop.
     *
     * @return FortDetails
     */
	public function getDetails()
    {
        $reqMsg = new FortDetailsMessage();
        $reqMsg->setFortId($this->getId());
        $reqMsg->setLatitude($this->getLatitude());
        $reqMsg->setLongitude($this->getLongitude());


        $serverRequest = new ServerRequest(RequestType::FORT_DETAILS, $reqMsg);

        $this->pokemonGoAPI->getRequestHandler()->sendServerRequests($serverRequest);
        $response = new FortDetailsResponse($serverRequest->getData());

        return new FortDetails($response);
	}

	/**
     * Returns whether this pokestop has an active lure.
     *
     * @return bool
     */
	public function hasLure()
    {
    $modifiers = $this->getDetails()->getModifier();
		foreach ($modifiers as $mod) {
            if ($mod->getItemId() == ItemId::ITEM_TROY_DISK) {
                return true;
            }
        }

		return false;
	}
    

    /**
     * @return FortData
     */
    public function getFortData()
    {
        return $this->fortData;
    }

    /**
     * @return int
     */
    public function getCooldownCompleteTimestampMs()
    {
        return $this->cooldownCompleteTimestampMs;
    }
}
