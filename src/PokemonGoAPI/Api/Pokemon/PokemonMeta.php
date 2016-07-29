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

    /**
     * PokemonMeta constructor.
     * @param $baseStam
     * @param $baseCaptureRate
     * @param $candiesToEvolve
     * @param $baseFleeRate
     * @param $pokedexHeight
     * @param $parent
     */
    function __construct($baseStam, $baseCaptureRate, $candiesToEvolve, $baseFleeRate, $pokedexHeight, $parent)
    {
        $this->baseStam = $baseStam;
        $this->baseCaptureRate = $baseCaptureRate;
        $this->candiesToEvolve = $candiesToEvolve;
        $this->baseFleeRate = $baseFleeRate;
        $this->parent = $parent;
    }

    /**
     * Return the capture rate
     *
     * @return mixed
     */
    public function getBaseCaptureRate()
    {
        return $this->baseCaptureRate;
    }

    /**
     * return the base flee rate
     *
     * @return mixed
     */
    public function getBaseFleeRate()
    {
        return $this->baseFleeRate;
    }

    /**
     * Return the base stamina
     *
     * @return mixed
     */
    public function getBaseStam()
    {
        return $this->baseStam;
    }

    /**
     * Return the needed candies to evolve
     *
     * @return mixed
     */
    public function getCandiesToEvolve()
    {
        return $this->candiesToEvolve;
    }

    /**
     * Return the parent
     *
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }
}