<?php
/**
 * User: tuttarealstep
 * Date: 25/07/16
 * Time: 19.32
 */

namespace PokemonGoAPI\Api\Player;

class Team
{
    const TEAM_NONE = 0;
    const TEAM_MYSTIC = 1;
    const TEAM_VALOR = 2;
    const TEAM_INSTINCT = 3;

    private $value;
    private $teamName;

    function __construct($value)
    {
        $this->value = $value;
        switch($this->value)
        {
            case 3:
                $this->teamName = "instinct";
                break;
            case 2:
                $this->teamName = "valor";
                break;
            case 1:
                $this->teamName = "mystic";
                break;
            case 0:
            default:
                $this->teamName = "none";
                break;
        }
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getTeamName()
    {
        return $this->teamName;
    }
}