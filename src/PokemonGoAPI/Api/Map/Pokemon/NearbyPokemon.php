<?php
/**
 * User: tuttarealstep
 * Date: 28/07/16
 * Time: 14.44
 */

namespace PokemonGoAPI\Api\Map\Pokemon;

class NearbyPokemon
{
    private $NearbyPokemon;

    public function __construct(\POGOProtos\Map\Pokemon\NearbyPokemon $NearbyPokemon) {
        $this->NearbyPokemon = $NearbyPokemon;
    }

    public function getPokemonId() {
		return  $this->NearbyPokemon->getPokemonId();
	}

	public function getDistanceInMeters() {
		return  $this->NearbyPokemon->getDistanceInMeters();
	}

	public function getEncounterId() {
		return  $this->NearbyPokemon->getEncounterId();
	}
}