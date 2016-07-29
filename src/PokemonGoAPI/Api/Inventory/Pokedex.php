<?php
/**
 * User: tuttarealstep
 * Date: 25/07/16
 * Time: 22.46
 */

namespace PokemonGoAPI\Api\Inventory;

use POGOProtos\Data\PokedexEntry;
use POGOProtos\Enums\PokemonId;
use PokemonGoAPI\Api\PokemonGoAPI;

class Pokedex
{
    private $PokemonGoAPI = null;
    private $pokedexMap = [];

    /**
     * Pokedex constructor.
     * @param PokemonGoAPI $PokemonGoAPI
     */
    function __construct(PokemonGoAPI $PokemonGoAPI)
    {
        $this->reset($PokemonGoAPI);
    }

    /**
     * Reset the pokedex
     *
     * @param PokemonGoAPI $pokemonGoAPI
     */
    public function reset(PokemonGoAPI $pokemonGoAPI) {
        $this->PokemonGoAPI = $pokemonGoAPI;
        $this->pokedexMap = [];
    }

    /**
     * Add a pokemon id in the pokedex
     *
     * @param PokedexEntry $entry
     */
    public function add(PokedexEntry $entry) {
        $id = $entry->getPokemonId();
        $this->pokedexMap[$id] = $entry;
    }

    /**
     * Return the pokemon family info
     *
     * @param $pokemonId
     * @return mixed
     */
    public function getPokedexEntry($pokemonId) {
        return $this->pokedexMap[$pokemonId];
    }
}