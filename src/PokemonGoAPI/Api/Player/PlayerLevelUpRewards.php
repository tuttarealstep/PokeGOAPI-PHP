<?php
/**
 * User: tuttarealstep
 * Date: 27/07/16
 * Time: 20.57
 */

namespace PokemonGoAPI\Api\Player;

class PlayerLevelUpRewards
{
    private $status = null;
    private $rewards = [];
    private $unlockedItems = [];

    //TODO RESPONSE

    function __construct($status)
    {
        $this->status = $status;
    }

    public function PlayerLevelUpRewards($response)
    {
        $this->rewards = $response->getItemsAwardedList();
        $this->unlockedItems = $response->getItemsUnlockedList();
        $this->status = (empty($this->rewards) ? "ALREADY_ACCEPTED" : "NEW");
    }
}