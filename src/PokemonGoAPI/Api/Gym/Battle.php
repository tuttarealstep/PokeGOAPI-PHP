<?php
/**
 * User: tuttarealstep
 * Date: 28/07/16
 * Time: 14.57
 */

namespace PokemonGoAPI\Api\Gym;

use POGOProtos\Data\Battle\BattleAction;
use POGOProtos\Data\Battle\BattleActionType;
use POGOProtos\Data\Battle\BattlePokemonInfo;
use POGOProtos\Data\Battle\BattleState;
use POGOProtos\Networking\Requests\Messages\AttackGymMessage;
use POGOProtos\Networking\Requests\Messages\StartGymBattleMessage;
use POGOProtos\Networking\Requests\RequestType;
use POGOProtos\Networking\Responses\AttackGymResponse;
use POGOProtos\Networking\Responses\StartGymBattleResponse;
use PokemonGoAPI\Api\Pokemon\Pokemon;
use PokemonGoAPI\Api\PokemonGoAPI;
use PokemonGoAPI\Main\ServerRequest;

class Battle
{
    private $gym;
    private $team;
    private $bteam = [];
    private $battleResponse;
    private $pokemonGoAPI;
    private $gymIndex = [];

    private $concluded;
    private $outcome;

    function __construct(PokemonGoAPI $pokemonGoAPI, $team, Gym $gym)
    {
        $this->team = $team;
        $this->gym = $gym;
        $this->pokemonGoAPI = $pokemonGoAPI;

        for($i = 0; $i < count($team); $i++)
        {
            $this->bteam[] = $this->createBattlePokemon($team[$i]);
        }
    }

    public function start()
    {
        $builder = new StartGymBattleMessage();

        for ($i = 0; $i < count($this->team); $i++) {
            $builder->addAttackingPokemonIds($this->team[$i]->getId());
        }


        $defenders = $this->gym->getDefendingPokemon();
        $builder->setGymId( $this->gym->getId());
        $builder->setPlayerLongitude($this->pokemonGoAPI->getLongitude());
        $builder->setPlayerLatitude($this->pokemonGoAPI->getLatitude());
        $builder->setDefendingPokemonId($defenders[0]->getId());

        $serverRequest = new ServerRequest(RequestType::START_GYM_BATTLE, $builder);
        $this->pokemonGoAPI->getRequestHandler()->sendServerRequests($serverRequest);

        $battleResponse = new StartGymBattleResponse($serverRequest->getData());

        $this->sendBlankAction();


        foreach ($battleResponse->getBattleLog()->getBattleActionsList() as $action)
        {
            $this->gymIndex[] = $action->getTargetIndex();
        }

        return $battleResponse->getResult();
    }

    public function attack($times)
    {
        $actions = [];

        for ($i = 0; $i < $times; $i++)
        {
            $action = new BattleAction();
            $action->setType(BattleActionType::ACTION_ATTACK);
            $action->setActionStartMs($this->pokemonGoAPI->currentTimeMillis() + (100 * $times));
            $action->setDurationMs(500);
            $action->setTargetIndex(-1);
            $actions[] = $action;
        }

        $result = $this->doActions($actions);

        return $result;
    }

    private function createBattlePokemon(Pokemon $pokemon)
    {
        $info = new BattlePokemonInfo();
        $info->setCurrentEnergy(0);
        $info->setCurrentHealth(100);
        $info->setPokemonData($pokemon->getDefaultInstanceForType());

        return $info;
    }

    private function getDefender($index)
    {
        return $this->gym->getGymMembers()[0]->getPokemonData();
    }

    private function getLastActionFromServer()
    {
        $actionCount = $this->battleResponse->getBattleLog()->getBattleActionsCount();
        $action = $this->battleResponse->getBattleLog()->getBattleActions($actionCount - 1);
        return $action;
    }

    private function sendBlankAction()
    {
        $message = new AttackGymMessage();
        $message->setGymId($this->gym->getId());
        $message->setPlayerLatitude($this->pokemonGoAPI->getLatitude());
        $message->setPlayerLongitude($this->pokemonGoAPI->getLongitude());
        $message->setBattleId($this->battleResponse->getBattleId());

        $serverRequest = new ServerRequest(RequestType::ATTACK_GYM, $message);
        $this->pokemonGoAPI->getRequestHandler()->sendServerRequests($serverRequest);

        return new AttackGymResponse($serverRequest->getData());
    }

    private function doActions($actions)
    {
        $message = new AttackGymMessage();
        $message->setGymId($this->gym->getId());
        $message->setPlayerLatitude($this->pokemonGoAPI->getLatitude());
        $message->setPlayerLongitude($this->pokemonGoAPI->getLongitude());
        $message->setBattleId($this->battleResponse->getBattleId());

        foreach ($actions as $action) {
            $message->addAttackActions($action);
        }

        $serverRequest = new ServerRequest(RequestType::ATTACK_GYM, $message);
        $this->pokemonGoAPI->getRequestHandler()->sendServerRequests($serverRequest);

        try
        {
            $response = new AttackGymResponse($serverRequest->getData());

            if ($response->getBattleLog()->getState() == BattleState::DEFEATED
                || $response->getBattleLog()->getState() == BattleState::VICTORY
                || $response->getBattleLog()->getState() == BattleState::TIMED_OUT) {
                $this->concluded = true;
            }

            $this->outcome = $response->getBattleLog()->getState();

            return $response;

        } catch (\Exception $e) {
            throw new \Exception($e);
        }

    }

    public function getConcluded()
    {
        return $this->concluded;
    }

    public function getOutcome()
    {
        return $this->outcome;
    }
}