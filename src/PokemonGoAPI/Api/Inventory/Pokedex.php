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

    function __construct(PokemonGoAPI $PokemonGoAPI)
    {
        $this->reset($PokemonGoAPI);
    }

    public function reset(PokemonGoAPI $pokemonGoAPI) {
        $this->PokemonGoAPI = $pokemonGoAPI;
        $this->pokedexMap = [];
    }

    public function add(PokedexEntry $entry) {
        $id = $entry->getPokemonId();
        $this->pokedexMap[$id] = $entry;
    }

    public function getPokedexEntry($pokemonId) {
        return $this->pokedexMap[$pokemonId];
    }
}