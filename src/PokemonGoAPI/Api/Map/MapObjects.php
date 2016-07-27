<?php
/**
 * User: tuttarealstep
 * Date: 27/07/16
 * Time: 22.03
 */

namespace PokemonGoAPI\Api\Map;

class MapObjects
{
    private $pokemonGoAPI;

    private $nearbyPokemons = [];
    private $catchablePokemons = [];
    private $wildPokemons = [];
    private $decimatedSpawnPoints = [];
    private $spawnPoints = [];
    private $gyms = [];
    private $pokestops = [];

    private $complete = false;

    function __construct($pokemonGoAPI)
    {
        $this->pokemonGoAPI = $pokemonGoAPI;
    }

    public function addNearbyPokemons($nearbyPokemons)
    {
        if($nearbyPokemons == null)
            return;

        if(empty($nearbyPokemons))
        {
            return;
        }

        $this->complete = true;
        $this->nearbyPokemons = $nearbyPokemons;
    }

    public function addCatchablePokemons($catchablePokemons)
    {
        if($catchablePokemons == null)
            return;

        if(empty($catchablePokemons))
        {
            return;
        }

        $this->complete = true;
        $this->catchablePokemons = $catchablePokemons;
    }

    public function addWildPokemons($wildPokemons)
    {
        if($wildPokemons == null)
            return;

        if(empty($wildPokemons))
        {
            return;
        }

        $this->complete = true;
        $this->wildPokemons = $wildPokemons;
    }

    public function addDecimatedSpawnPoints($decimatedSpawnPoints)
    {
        if($decimatedSpawnPoints == null)
            return;

        if(empty($decimatedSpawnPoints))
        {
            return;
        }

        $this->complete = true;
        $this->decimatedSpawnPoints = $decimatedSpawnPoints;
    }

    public function addSpawnPoints($spawnPoints)
    {
        if($spawnPoints == null)
            return;

        if(empty($spawnPoints))
        {
            return;
        }

        $this->complete = true;
        $this->spawnPoints = $spawnPoints;
    }

    public function addGyms($gyms)
    {
        if($gyms == null)
            return;

        if(empty($gyms))
        {
            return;
        }

        $this->complete = true;
        $this->gyms = $gyms;
    }

    public function addPokestops($pokestops)
    {
        if($pokestops == null)
            return;

        if(empty($pokestops))
        {
            return;
        }

        $this->complete = true;
        $this->pokestops = $pokestops;
    }

    public function isComplete()
    {
        return $this->complete;
    }

    public function update(MapObjects $other)
    {
        $this->nearbyPokemons = [];
        $this->addNearbyPokemons($other->getNearbyPokemons());

        $this->catchablePokemons= [];
        $this->addCatchablePokemons($other->getCatchablePokemons());

        $this->wildPokemons= [];
        $this->addWildPokemons($other->getWildPokemons());

        $this->decimatedSpawnPoints= [];
        $this->addDecimatedSpawnPoints($other->getDecimatedSpawnPoints());

        $this->spawnPoints= [];
        $this-> addSpawnPoints($other->getSpawnPoints());


        foreach($other->getGyms() as $otherGym)
        {
            foreach($this->getGyms() as $gym) {
                if ($otherGym->getId() == ($gym->getId())) {
                    unset($this->gyms[$gym]);
                    break;
                }
            }
			$this->gyms[] = $otherGym;
        }

        foreach($other->getPokestops() as $otherPokestop)
        {
            foreach($this->pokestops as $pokestop) {
                if ($otherPokestop->getId() == ($pokestop->getId())) {
                    unset($this->pokestops[$pokestop]);
                    break;
                }
            }
            $this->pokestops[] = $otherPokestop;
        }
    }

    public function getCatchablePokemons()
    {
        return $this->catchablePokemons;
    }

    public function getDecimatedSpawnPoints()
    {
        return $this->decimatedSpawnPoints;
    }

    public function getGyms()
    {
        return $this->gyms;
    }

    public function getNearbyPokemons()
    {
        return $this->nearbyPokemons;
    }

    public function getPokemonGoAPI()
    {
        return $this->pokemonGoAPI;
    }

    public function getPokestops()
    {
        return $this->pokestops;
    }

    public function getSpawnPoints()
    {
        return $this->spawnPoints;
    }

    public function getWildPokemons()
    {
        return $this->wildPokemons;
    }
}