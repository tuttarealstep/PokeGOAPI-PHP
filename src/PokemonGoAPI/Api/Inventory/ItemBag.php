<?php
/**
 * User: tuttarealstep
 * Date: 25/07/16
 * Time: 22.44
 */

namespace PokemonGoAPI\Api\Inventory;

use POGOProtos\Inventory\Item\ItemData;
use POGOProtos\Inventory\Item\ItemId;
use POGOProtos\Networking\Requests\Messages\RecycleInventoryItemMessage;
use POGOProtos\Networking\Requests\RequestType;
use POGOProtos\Networking\Responses\RecycleInventoryItemResponse;
use POGOProtos\Networking\Responses\RecycleInventoryItemResponse_Result;
use PokemonGoAPI\Api\PokemonGoAPI;
use PokemonGoAPI\Main\ServerRequest;

class ItemBag
{
    private $PokemonGoAPI = null;
    private $items = null;

    function __construct(PokemonGoAPI $PokemonGoAPI)
    {
        $this->reset($PokemonGoAPI);
    }

    public function reset(PokemonGoAPI $PokemonGoAPI)
    {
        $this->PokemonGoAPI = $PokemonGoAPI;
        $this->items = [];
    }

    public function addItem(Item $item)
    {
        $this->items[$item->getItemId()] = $item;
    }

    public function removeItem(ItemId $id, $quantity)
    {
        $item = $this->getItem($id);
        if($item->getCount() < $quantity)
        {
            throw new \Exception("You cannont remove more quantity than you have");
        }

        $message = new RecycleInventoryItemMessage();
        $message->setItemId($id);
        $message->setCount($quantity);

        $serverRequest = new ServerRequest(RequestType::RECYCLE_INVENTORY_ITEM, $message);
        $this->PokemonGoAPI->getRequestHandler()->sendServerRequests($serverRequest);

        $response = new RecycleInventoryItemResponse($serverRequest->getData());

        if($response->getResult() == RecycleInventoryItemResponse_Result::SUCCESS)
        {
            $item->setCount($response->getNewCount());
        }

        return $response->getResult();
    }

    public function getItem($id)
    {
        if($id == ItemId::ITEM_UNKNOWN)
        {
            throw new \Exception("You cannot get item for UNRECOGNIZED");
        }

        if(!array_key_exists($id, $this->items))
        {
            $itemData = new ItemData();
            $itemData->setCount(0);
            $itemData->setItemId($id);
            return new Item($itemData);
        }

        return $this->items[$id];
    }

    public function getItems()
    {
        return $this->items;
    }
}