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
    /**
     * The RequestHandler Class
     * @var null|RequestHandler
     */
    private $RequestHandler = null;

    /**
     * The PlayerProfile Class
     * @var null|PlayerProfile
     */
    private $PlayerProfile = null;

    /**
     * The user login token
     * @var string
     */
    private $userToken = null;

    /**
     * The user provider
     * @var string
     */
    private $userProvider = null;

    /**
     * The inventories class
     * @var null|Inventories
     */
    private $inventories = null;

    /**
     * The map class
     * @var null|Map
     */
    private $map = null;

    /**
     * The latitude coordinate
     * @var float
     */
    private $latitude = 40.77878553364602;

    /**
     * The longitude coordinate
     * @var float
     */
    private $longitude = -73.96834745844728;

    /**
     * The altitude coordinate
     * @var int
     */
    private $altitude = 35;

    /**
     * The output class
     * @var null|Output
     */
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

    /**
     * Return the map.
     *
     * @return Map
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * Return Output class
     *
     * @return Output
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * Return the player profile
     *
     * @return PlayerProfile
     */
    public function getPlayerProfile()
    {
        return $this->PlayerProfile;
    }

    /**
     * Return the player inventory
     *
     * @return Inventories
     */
    public function getInventories()
    {
        return $this->inventories;
    }

    /**
     * Return the latitude coordinate
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Return the altitude coordinate
     *
     * @return int|float
     */
    public function getAltitude()
    {
        return $this->altitude;
    }

    /**
     * Return the longitude coordinate
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set the altitude variable
     *
     * @param $altitude
     */
    public function setAltitude($altitude)
    {
        $this->altitude = $altitude;
    }

    /**
     * Set the latitude variable
     *
     * @param $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * Set the longitude variable
     *
     * @param $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * Return the user token
     *
     * @return string
     */
    public function getUserToken()
    {
        return $this->userToken;
    }

    /**
     * Return the user login provider
     * @return string
     */
    public function getUserProvider()
    {
        return $this->userProvider;
    }

    /**
     * Return the api endpoint url
     *
     * @return string
     */
    public function getApiEndpoint()
    {
        return Settings::API_ENDPOINT;
    }

    /**
     * Return used user agent
     *
     * @return string
     */
    public function getUserAgent()
    {
        return Settings::USER_AGENT;
    }

    /**
     * Return the RequestHandler class
     *
     * @return RequestHandler
     */
    public function getRequestHandler()
    {
        return $this->RequestHandler;
    }

    /**
     * Return the current time in millis
     * @return float
     */
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