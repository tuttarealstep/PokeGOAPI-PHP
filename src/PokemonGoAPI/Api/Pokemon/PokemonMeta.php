<?php
/**
 * User: tuttarealstep
 * Date: 26/07/16
 * Time: 12.22
 */

namespace PokemonGoAPI\Api\Pokemon;

use POGOProtos\Enums\PokemonId;

class PokemonMeta
{
    private $baseStam;
    private $baseCaptureRate;
    private $candiesToEvolve;
    private $baseFleeRate;
    private $parent;

    function __construct($baseStam, $baseCaptureRate, $candiesToEvolve, $baseFleeRate, $pokedexHeight, $parent)
    {
        $this->baseStam = $baseStam;
        $this->baseCaptureRate = $baseCaptureRate;
        $this->candiesToEvolve = $candiesToEvolve;
        $this->baseFleeRate = $baseFleeRate;
        $this->parent = $parent;
    }

    public function getBaseCaptureRate()
    {
        return $this->baseCaptureRate;
    }

    public function getBaseFleeRate()
    {
        return $this->baseFleeRate;
    }

    public function getBaseStam()
    {
        return $this->baseStam;
    }

    public function getCandiesToEvolve()
    {
        return $this->candiesToEvolve;
    }

    public function getParent()
    {
        return $this->parent;
    }
}