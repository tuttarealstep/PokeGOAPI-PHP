<?php
/**
 * User: tuttarealstep
 * Date: 25/07/16
 * Time: 22.56
 */

namespace PokemonGoAPI\Api\Inventory;

use POGOProtos\Inventory\Item\ItemData;
use POGOProtos\Inventory\Item\ItemId;

class Item
{
    private $itemData;
    private $count;

    function __construct(ItemData $itemData)
    {
        $this->itemData = $itemData;
        $this->count = $itemData->getCount();
    }

    public function getItemId()
    {
        return $this->itemData->getItemId();
    }

    public function getCount()
    {
        return $this->count;
    }

    public function setCount($count)
    {
        $this->count = $count;
    }

    public function isUnseen()
    {
        return $this->itemData->getUnseen();
    }

    public function isPotion()
    {
        return $this->getItemId() == ItemId::ITEM_POTION
        || $this->getItemId() == ItemId::ITEM_SUPER_POTION
        || $this->getItemId() == ItemId::ITEM_HYPER_POTION
        || $this->getItemId() == ItemId::ITEM_MAX_POTION
            ;
    }

    public function isRevive()
    {
        return $this->getItemId() == ItemId::ITEM_REVIVE
        || $this->getItemId() == ItemId::ITEM_MAX_REVIVE
            ;
    }

}