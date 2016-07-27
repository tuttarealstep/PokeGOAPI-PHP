<?php
/**
 * User: tuttarealstep
 * Date: 25/07/16
 * Time: 22.46
 */

namespace PokemonGoAPI\Api\Inventory;

use PokemonGoAPI\Api\Pokemon\Pokemon;
use PokemonGoAPI\Api\PokemonGoAPI;

class PokeBank
{
    private $PokemonGoAPI = null;

    public $pokemons = [];

    function __construct(PokemonGoAPI $PokemonGoAPI)
    {
        $this->reset($PokemonGoAPI);
    }

    function reset(PokemonGoAPI $PokemonGoAPI)
    {
        $this->PokemonGoAPI = $PokemonGoAPI;
        $this->pokemons = [];
    }

    public function addPokemon(Pokemon $pokemon)
    {
        $alreadyAdded = array_filter($this->pokemons, function($testPokemon) use ($pokemon)
        {
            return ($pokemon->getId() == $testPokemon->getId());
        });

        if(count($alreadyAdded) < 1)
        {
            $this->pokemons[] = $pokemon;
        }
    }

    public function getPokemonByPokemonId($id)
    {
       return array_filter($this->pokemons, function($testPokemon) use ($id)
        {
            if($testPokemon->getPokemonId() == $id)
            {
                return true;
            }

            return false;
        });
    }

    public function removePokemon($pokemon)
    {
        return array_filter($this->pokemons, function($testPokemon) use ($pokemon)
        {
            if($testPokemon->getId() != $pokemon->getId())
            {
                return true;
            }

            return false;
        });
    }

    public function getPokemonById($id)
    {
        foreach($this->pokemons as $pokemon)
        {
            if($pokemon->getId() == $id)
            {
                return $pokemon;
            }
        }

        return null;
    }
}