<?php
/**
 * User: tuttarealstep
 * Date: 23/07/16
 * Time: 18.45
 */

namespace PokemonGoAPI\Api;

use PokemonGoAPI\Api\Inventory\Inventories;
use PokemonGoAPI\Api\Map\Map;
use PokemonGoAPI\Api\Player\PlayerProfile;
use PokemonGoAPI\Main\RequestHandler;
use PokemonGoAPI\Main\Settings;
use PokemonGoAPI\Utils\Output;

class PokemonGoAPI
{
    private $RequestHandler = null;
    private $PlayerProfile = null;
    private $userToken = null;
    private $userProvider = null;
    private $inventories = null;
    private $map = null;

    private $latitude = 40.77878553364602;
    private $longitude = -73.96834745844728;
    private $altitude = 35;

    private $output = null;

    /**
     * PokemonGoAPI constructor.
     * @param $userToken
     */
    function __construct($userToken)
    {
        $this->output = new Output();

        $this->userToken = $userToken["Auth"];
        $this->userProvider = $userToken["Provider"];

        $this->RequestHandler = new RequestHandler($this, $this->userToken);

        $this->PlayerProfile = new PlayerProfile($this);
        $this->inventories = new Inventories($this);

        $this->PlayerProfile->updateProfile();
        $this->inventories->updateInventories(false);

        $this->map = new Map($this);
    }

    public function getMap()
    {
        return $this->map;
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function getPlayerProfile()
    {
        return $this->PlayerProfile;
    }

    public function getInventories()
    {
        return $this->inventories;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function getAltitude()
    {
        return $this->altitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param $altitude
     */
    public function setAltitude($altitude)
    {
        $this->altitude = $altitude;
    }

    /**
     * @param $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @param $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    public function getUserToken()
    {
        return $this->userToken;
    }

    public function getUserProvider()
    {
        return $this->userProvider;
    }

    public function getApiEndpoint()
    {
        return Settings::API_ENDPOINT;
    }

    public function getUserAgent()
    {
        return Settings::USER_AGENT;
    }

    public function getRequestHandler()
    {
        return $this->RequestHandler;
    }

    public function currentTimeMillis()
    {
        return round(microtime(true) * 1000);
    }

    /**
     * @param $latitude
     * @param $longitude
     * @param $altitude
     */
    public function setLocation($latitude, $longitude, $altitude)
    {
        $this->setLatitude($latitude);
        $this->setLongitude($longitude);
        $this->setAltitude($altitude);
    }
}