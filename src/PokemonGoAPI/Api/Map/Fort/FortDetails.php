<?php
/**
 * User: tuttarealstep
 * Date: 28/07/16
 * Time: 11.52
 */

namespace PokemonGoAPI\Api\Map\Fort;

use POGOProtos\Networking\Responses\FortDetailsResponse;

class FortDetails
{
    private $FortDetailsResponse = null;

    function __construct(FortDetailsResponse $FortDetailsResponse)
    {
        $this->FortDetailsResponse = $FortDetailsResponse;
    }

    public function getId() 
    {
        return $this->FortDetailsResponse->getFortId();
    }

    public function getTeam() 
    {
		return $this->FortDetailsResponse->getTeamColor();
	}

	public function getName() 
    {
		return $this->FortDetailsResponse->getName();
	}

	public function getImageUrl() 
    {
		return $this->FortDetailsResponse->getImageUrlsArray();
	}

	public function getFp() 
    {
		return $this->FortDetailsResponse->getFp();
	}

	public function getStamina() 
    {
		return $this->FortDetailsResponse->getStamina();
	}

	public function getMaxStamina() 
    {
		return $this->FortDetailsResponse->getMaxStamina();
	}

	public function getFortType() 
    {
		return $this->FortDetailsResponse->getType();
	}

	public function getLatitude() 
    {
		return $this->FortDetailsResponse->getLatitude();
	}

	public function getLongitude()
    {
		return $this->FortDetailsResponse->getLongitude();
	}

	public function getDescription() 
    {
		return $this->FortDetailsResponse->getDescription();
	}

	public function getModifier() 
    {
		return $this->FortDetailsResponse->getModifiersArray();
	} 
}
