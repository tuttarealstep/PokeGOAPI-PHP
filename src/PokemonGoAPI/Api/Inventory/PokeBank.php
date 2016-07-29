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

    /**
     * PokeBank constructor.
     * @param PokemonGoAPI $PokemonGoAPI
     */
    function __construct(PokemonGoAPI $PokemonGoAPI)
    {
        $this->reset($PokemonGoAPI);
    }

    /**
     * Reset the PokeBank
     * @param PokemonGoAPI $PokemonGoAPI
     */
    function reset(PokemonGoAPI $PokemonGoAPI)
    {
        $this->PokemonGoAPI = $PokemonGoAPI;
        $this->pokemons = [];
    }

    /**
     * Add a new pokemon
     *
     * @param Pokemon $pokemon
     */
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

    /**
     * Search a pokemon by its pokemonid
     *
     * @param $id
     * @return array
     */
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

    /**
     * Remove pokemon
     *
     * @param $pokemon
     * @return array
     */
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

    /**
     * Return a pokemon by its id
     *
     * @param $id
     * @return null
     */
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