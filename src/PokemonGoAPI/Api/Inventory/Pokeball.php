<?php
/**
 * User: tuttarealstep
 * Date: 28/07/16
 * Time: 12.20
 */

namespace PokemonGoAPI\Api\Inventory;

use POGOProtos\Inventory\Item\ItemId;

class Pokeball
{
    private $ballType = null;

    const POKEBALL = ItemId::ITEM_POKE_BALL;
    const GREATBALL= ItemId::ITEM_GREAT_BALL;
    const ULTRABALL = ItemId::ITEM_ULTRA_BALL;
    const MASTERBALL = ItemId::ITEM_MASTER_BALL;

    function __construct($type)
    {
        $this->ballType = $type;
    }

    public function getBallType()
    {
        return $this->ballType;
    }
}