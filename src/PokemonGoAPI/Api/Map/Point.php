<?php
/**
 * User: tuttarealstep
 * Date: 28/07/16
 * Time: 14.48
 */

namespace PokemonGoAPI\Api\Map;

use POGOProtos\Map\SpawnPoint;

class Point
{
    private $longitude;
    private $latitude;

    function __construct($latitude = null, $longitude = null, SpawnPoint $spawnPoint = null)
    {
        if($spawnPoint != null)
        {
            $this->latitude = $spawnPoint->getLatitude();
            $this->longitude = $spawnPoint->getLongitude();
        } else {
            $this->latitude = $latitude;
            $this->longitude = $longitude;
        }
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }
}