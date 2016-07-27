<?php
/**
 * User: tuttarealstep
 * Date: 27/07/16
 * Time: 21.33
 */

namespace PokemonGoAPI\Api\Pokemon;

class HatchedEgg
{
    private $id;
    private $experience;
    private $candy;
    private $stardust;

    function __construct($id, $experience, $candy, $stardust)
    {
        $this->id = $id;
        $this->experience = $experience;
        $this->candy = $candy;
        $this->stardust = $stardust;
    }

    public function getCandy()
    {
        return $this->candy;
    }

    public function getExperience()
    {
        return $this->experience;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getStardust()
    {
        return $this->stardust;
    }
}