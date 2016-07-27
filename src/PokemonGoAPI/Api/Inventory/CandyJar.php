<?php
/**
 * User: tuttarealstep
 * Date: 25/07/16
 * Time: 22.46
 */

namespace PokemonGoAPI\Api\Inventory;

use POGOProtos\Enums\PokemonFamilyId;
use PokemonGoAPI\Api\PokemonGoAPI;

class CandyJar
{
    private $PokemonGoAPI = null;
    private $candies = null;

    function __construct(PokemonGoAPI $PokemonGoAPI)
    {
        $this->reset($PokemonGoAPI);
    }

    function reset(PokemonGoAPI $pokemonGoAPI)
    {
        $this->PokemonGoAPI = $pokemonGoAPI;
        $this->candies = [];
    }

    public function setCandy($family, $candies)
    {
        $this->candies[$family] = $candies;
    }

    public function addCandy($family, $amount)
    {
        if (array_key_exists($family, $this->candies)) {
            $this->candies[$family] = $this->candies[$family] + $amount;
        } else {
            $this->candies[$family] = $amount;
        }
    }

    public function removeCandy($family, $amount)
    {
        if (array_key_exists($family, $this->candies)) {
            if ( $this->candies[$family] - $amount < 0) {
                $this->candies[$family] = 0;
            } else {
                $this->candies[$family] = $this->candies[$family] - $amount;
            }
        } else {
            $this->candies[$family] = 0;
        }
    }


    public function getCandies($family)
    {
        if (array_key_exists($family, $this->candies)) {
            return $this->candies[$family];
        } else {
            return 0;
        }
    }
}