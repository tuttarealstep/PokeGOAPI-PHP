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
        $this->pokemons     = [];
    }

    /**
     * Add a new pokemon
     *
     * @param Pokemon $pokemon
     */
    public function addPokemon(Pokemon $pokemon)
    {
        $this->pokemons[$pokemon->getId()] = $pokemon;
    }

    /**
     * Search a pokemon by its pokemonid
     *
     * @param $id
     * @return Pokemon[]
     */
    public function getPokemonByPokemonId($id)
    {
        return array_filter($this->pokemons, function ($testPokemon) use ($id) {
            /** @var $testPokemon Pokemon */
            return $testPokemon->getPokemonId() == $id;
        });
    }

    /**
     * Remove pokemon
     *
     * @param $pokemon
     * @return Pokemon[]
     */
    public function removePokemon($pokemon)
    {
        return array_filter($this->pokemons, function ($testPokemon) use ($pokemon) {
            /** @var $testPokemon Pokemon */
            return ($testPokemon->getId() != $pokemon->getId());
        });
    }

    /**
     * Return a pokemon by its id
     *
     * @param $id
     * @return null|Pokemon
     */
    public function getPokemonById($id)
    {
        return array_key_exists($id, $this->pokemons) ? $this->pokemons[$id] : null;
    }
}