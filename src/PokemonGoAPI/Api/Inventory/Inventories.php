<?php
/**
 * User: tuttarealstep
 * Date: 25/07/16
 * Time: 22.40
 */

namespace PokemonGoAPI\Api\Inventory;

use POGOProtos\Enums\PokemonFamilyId;
use POGOProtos\Enums\PokemonId;
use POGOProtos\Inventory\Item\ItemId;
use POGOProtos\Networking\Requests\Messages\GetInventoryMessage;
use POGOProtos\Networking\Requests\RequestType;
use POGOProtos\Networking\Responses\GetInventoryResponse;
use PokemonGoAPI\Api\Pokemon\EggPokemon;
use PokemonGoAPI\Api\Pokemon\Pokemon;
use PokemonGoAPI\Api\PokemonGoAPI;
use PokemonGoAPI\Main\ServerRequest;

class Inventories
{
    private $PokemonGoAPI = null;

    private $itemBag = null;
    private $pokeBank = null;
    private $candyJar = null;
    private $pokedex = null;
    private $incubators = null;
    private $hatchery = null;

    private $lastInventoryUpdate = 0;

    /**
     * Inventories constructor.
     * @param PokemonGoAPI $PokemonGoAPI
     */
    function __construct(PokemonGoAPI $PokemonGoAPI)
    {
        $this->PokemonGoAPI = $PokemonGoAPI;

        $this->itemBag = new ItemBag($this->PokemonGoAPI);
        $this->pokeBank = new PokeBank($this->PokemonGoAPI);
        $this->candyJar = new CandyJar($this->PokemonGoAPI);
        $this->pokedex = new Pokedex($this->PokemonGoAPI);
        $this->incubators = [];
        $this->hatchery = new Hatchery($this->PokemonGoAPI);

        $this->updateInventories(false);
    }

    /**
     * Function for upgrade the inventory
     *
     * if $forceUpdate = true it reset all inventory containers
     *
     * @param bool $forceUpdate
     */
    public function updateInventories($forceUpdate = false)
    {
        if($forceUpdate)
        {
            $this->lastInventoryUpdate = 0;
            $this->itemBag->reset($this->PokemonGoAPI);
            $this->pokeBank->reset($this->PokemonGoAPI);
            $this->candyJar->reset($this->PokemonGoAPI);
            $this->pokedex->reset($this->PokemonGoAPI);
            $this->incubators = [];
            $this->hatchery->reset($this->PokemonGoAPI);
        }

        $inventoryRequestMessage = new GetInventoryMessage();
        $inventoryRequestMessage->setLastTimestampMs($this->lastInventoryUpdate);
        $inventoryRequest = new ServerRequest(RequestType::GET_INVENTORY, $inventoryRequestMessage);
        $this->PokemonGoAPI->getRequestHandler()->sendServerRequests($inventoryRequest);

        $response = new GetInventoryResponse($inventoryRequest->getData());

            foreach ($response->getInventoryDelta()->getInventoryItemsArray() as $inventoryItem)
            {
                $itemData = $inventoryItem->getInventoryItemData();

                if (!empty($itemData->getPokemonData())) {
                    // hatchery
                    if ($itemData->getPokemonData()->getPokemonId() == PokemonId::MISSINGNO && $itemData->getPokemonData()->getIsEgg()) {
                        $this->hatchery->addEgg(new EggPokemon($itemData->getPokemonData()));
                    }

                    // pokebank
                    if ($itemData->getPokemonData()->getPokemonId() != PokemonId::MISSINGNO) {
                        $this->pokeBank->addPokemon(new Pokemon($this->PokemonGoAPI, $inventoryItem->getInventoryItemData()->getPokemonData()));
                    }
                }

                if (!empty($itemData->getItem())) {
                    // items
                    if ($itemData->getItem()->getItemId() != ItemId::ITEM_UNKNOWN && $itemData->getItem()->getItemId() != ItemId::ITEM_UNKNOWN) {
                        $item = $itemData->getItem();
                        $this->itemBag->addItem(new Item($item));
                    }
                }

                if (!empty($itemData->getPokemonFamily())) {
                    // candyjar
                    if ($itemData->getPokemonFamily()->getFamilyId() != PokemonFamilyId::FAMILY_UNSET) {
                        $this->candyJar->setCandy(
                            $itemData->getPokemonFamily()->getFamilyId(),
                            $itemData->getPokemonFamily()->getCandy()
                        );
                    }
                }

                // player stats
                if (!empty($itemData->getPlayerStats())) {
                    $this->PokemonGoAPI->getPlayerProfile()->setStats($itemData->getPlayerStats());
                }

                // pokedex
                if (!empty($itemData->getPokedexEntry())) {
                    $this->pokedex->add($itemData->getPokedexEntry());
                }

                if (!empty($itemData->getEggIncubators())) {
                    foreach ($itemData->getEggIncubators()->getEggIncubatorArray() as $incubator) {
                        $this->incubators[] = new EggIncubator($this->PokemonGoAPI, $incubator);
                    }
                }

                $this->lastInventoryUpdate = round(microtime(true) * 1000);
            }
    }

    /**
     * Return the Candy Jar with all pokemon candy
     *
     * @return null|CandyJar
     */
    public function getCandyJar()
    {
        return $this->candyJar;
    }

    /**
     * Return the Hatchery
     *
     * @return null|Hatchery
     */
    public function getHatchery()
    {
        return $this->hatchery;
    }

    /**
     * Return all incubators
     *
     * @return array|null
     */
    public function getIncubators()
    {
        return $this->incubators;
    }

    /**
     * Return the item bag
     * with all items
     *
     * @return null|ItemBag
     */
    public function getItemBag()
    {
        return $this->itemBag;
    }

    /**
     * Return the poke bank
     * with all pokemon
     *
     * @return null|PokeBank
     */
    public function getPokeBank()
    {
        return $this->pokeBank;
    }

    /**
     * Return the user pokedex
     *
     * @return null|Pokedex
     */
    public function getPokedex()
    {
        return $this->pokedex;
    }
}