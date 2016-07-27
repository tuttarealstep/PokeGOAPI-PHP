<?php
/**
 * User: tuttarealstep
 * Date: 25/07/16
 * Time: 23.52
 */

namespace PokemonGoAPI\Api\Map\Pokemon;

use POGOProtos\Networking\Responses\EvolvePokemonResponse;
use POGOProtos\Networking\Responses\EvolvePokemonResponse_Result;
use PokemonGoAPI\Api\Pokemon\Pokemon;
use PokemonGoAPI\Api\PokemonGoAPI;

class EvolutionResult
{
    private $pokemonGoAPI = null;
    private $pokemon = null;
    private $pokemonEvolveResponse = null;

    function __construct(PokemonGoAPI $pokemonGoAPI, EvolvePokemonResponse $pokemonEvolveResponse)
    {
        $this->pokemonGoAPI = $pokemonGoAPI;
        $this->pokemonEvolveResponse = $pokemonEvolveResponse;
        $this->pokemon = new Pokemon($pokemonGoAPI, $pokemonEvolveResponse->getEvolvedPokemonData());
    }

    public function getResult()
    {
        return $this->pokemonEvolveResponse->getResult();
    }

    public function getEvolvedPokemon()
    {
        return $this->pokemon;
    }

    public function getExpAwarded()
    {
        return $this->pokemonEvolveResponse->getExperienceAwarded();
    }

    public function getCandyAwarded()
    {
        return $this->pokemonEvolveResponse->getCandyAwarded();
    }

    public function isSuccessful()
    {
        if($this->getResult() == EvolvePokemonResponse_Result::SUCCESS)
        {
            return true;
        }

        return false;
    }
}