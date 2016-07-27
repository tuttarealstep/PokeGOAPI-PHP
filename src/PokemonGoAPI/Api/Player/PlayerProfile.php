<?php
/**
 * User: tuttarealstep
 * Date: 23/07/16
 * Time: 19.28
 */

namespace PokemonGoAPI\Api\Player;


use POGOProtos\Data\Player\ContactSettings;
use POGOProtos\Data\Player\DailyBonus;
use POGOProtos\Data\Player\PlayerAvatar;
use POGOProtos\Networking\Requests\Messages\GetPlayerMessage;
use POGOProtos\Networking\Requests\RequestType;
use POGOProtos\Networking\Responses\GetPlayerResponse;
use PokemonGoAPI\Api\PokemonGoAPI;
use PokemonGoAPI\Main\ServerRequest;

class PlayerProfile
{
    private $PokemonGoAPI = null;

    private $badge;
    private $creationTime;
    private $itemStorage;
    private $pokemonStorage;
    private $username;
    private $team;
    private $currencies;

    private $avatar;
    private $dailyBonus;

    private $stats = null;

    function __construct(PokemonGoAPI $PokemonGoAPI)
    {
        $this->PokemonGoAPI = $PokemonGoAPI;
        $this->updateProfile();
    }

    public function updateProfile()
    {
        $getPlayerRequest = new ServerRequest(RequestType::GET_PLAYER);
        $getPLayerRequestMessage = new GetPlayerMessage();
        $this->PokemonGoAPI->getRequestHandler()->sendServerRequests($getPlayerRequest, $getPLayerRequestMessage->toProtobuf());

        $playerResponse = new GetPlayerResponse($getPlayerRequest->getData());

        $playerData = $playerResponse->getPlayerData();

        $this->badge = $playerData->getEquippedBadge();
        $this->creationTime = $playerData->getCreationTimestampMs();
        $this->itemStorage = $playerData->getMaxItemStorage();
        $this->pokemonStorage = $playerData->getMaxPokemonStorage();
        $this->team = (new Team($playerData->getTeam()))->getValue();
        $this->username = $playerData->getUsername();

        $avatarApi = new PlayerAvatar();
        $bonusApi = new DailyBonus();
        $contactApi = new ContactSettings();

        foreach($playerResponse->getPlayerData()->getCurrenciesArray() as $currency)
        {
            $this->addCurrency($currency->getName(), $currency->getAmount());
        }

        $avatarApi->setGender($playerResponse->getPlayerData()->getAvatar()->getGender());
        $avatarApi->setBackpack($playerResponse->getPlayerData()->getAvatar()->getBackpack());
        $avatarApi->setEyes($playerResponse->getPlayerData()->getAvatar()->getEyes());
        $avatarApi->setHair($playerResponse->getPlayerData()->getAvatar()->getHair());
        $avatarApi->setHat($playerResponse->getPlayerData()->getAvatar()->getHat());
        $avatarApi->setPants($playerResponse->getPlayerData()->getAvatar()->getPants());
        $avatarApi->setShirt($playerResponse->getPlayerData()->getAvatar()->getShirt());
        $avatarApi->setShoes($playerResponse->getPlayerData()->getAvatar()->getShoes());
        $avatarApi->setSkin($playerResponse->getPlayerData()->getAvatar()->getSkin());

        $bonusApi->setNextCollectedTimestampMs($playerResponse->getPlayerData()->getDailyBonus()->getNextCollectedTimestampMs());
        $bonusApi->setNextCollectedTimestampMs($playerResponse->getPlayerData()->getDailyBonus()->getNextDefenderBonusCollectTimestampMs());

        $this->avatar = $avatarApi;
        $this->dailyBonus = $bonusApi;
    }

    public function addCurrency($name, $amount)
    {
        switch($name)
        {
            case "POKECOIN":
                $this->currencies["POKECOIN"] = $amount;
                break;
            case "STARDUST":
                $this->currencies["STARDUST"] = $amount;
                break;
        }
    }

    public function getCurrency($currency)
    {
        if(array_key_exists($currency, $this->currencies))
        {
            return $this->currencies[$currency];
        }

        return null;
    }

    public function acceptLevelUpRewards($level)
    {

    }


    public function getAvatar()
    {
        return $this->avatar;
    }

    public function getBadge()
    {
        return $this->badge;
    }

    public function getCreationTime()
    {
        return $this->creationTime;
    }

    public function getCurrencies()
    {
        return $this->currencies;
    }

    public function getDailyBonus()
    {
        return $this->dailyBonus;
    }

    public function getItemStorage()
    {
        return $this->itemStorage;
    }

    public function getPokemonStorage()
    {
        return $this->pokemonStorage;
    }

    public function getTeam()
    {
        return $this->team;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getStats()
    {
        return $this->stats;
    }

    public function setStats($stats)
    {
        $this->stats = $stats;
    }
}