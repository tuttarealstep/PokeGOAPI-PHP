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

    /**
     * Item constructor.
     * @param ItemData $itemData
     */
    function __construct(ItemData $itemData)
    {
        $this->itemData = $itemData;
        $this->count = $itemData->getCount();
    }

    /**
     * Return the item id
     *
     * @return int
     */
    public function getItemId()
    {
        return $this->itemData->getItemId();
    }

    /**
     * Return the item count
     *
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set the item count
     * @param $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return bool
     */
    public function isUnseen()
    {
        return $this->itemData->getUnseen();
    }

    /**
     * Return true if the item is a potion
     *
     * @return bool
     */
    public function isPotion()
    {
        return $this->getItemId() == ItemId::ITEM_POTION
        || $this->getItemId() == ItemId::ITEM_SUPER_POTION
        || $this->getItemId() == ItemId::ITEM_HYPER_POTION
        || $this->getItemId() == ItemId::ITEM_MAX_POTION
            ;
    }

    /**
     * Return true if is a revive
     *
     * @return bool
     */
    public function isRevive()
    {
        return $this->getItemId() == ItemId::ITEM_REVIVE
        || $this->getItemId() == ItemId::ITEM_MAX_REVIVE
            ;
    }

}