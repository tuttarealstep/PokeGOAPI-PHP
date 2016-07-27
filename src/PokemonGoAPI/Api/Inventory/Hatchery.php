<?php
/**
 * User: tuttarealstep
 * Date: 25/07/16
 * Time: 22.46
 */

namespace PokemonGoAPI\Api\Inventory;

use POGOProtos\Networking\Requests\Messages\GetHatchedEggsMessage;
use POGOProtos\Networking\Requests\RequestType;
use POGOProtos\Networking\Responses\GetHatchedEggsResponse;
use PokemonGoAPI\Api\Pokemon\EggPokemon;
use PokemonGoAPI\Api\Pokemon\HatchedEgg;
use PokemonGoAPI\Api\PokemonGoAPI;
use PokemonGoAPI\Main\ServerRequest;

class Hatchery
{
    private $PokemonGoAPI = null;
    private $eggs = [];

    function __construct(PokemonGoAPI $PokemonGoAPI)
    {
        $this->reset($PokemonGoAPI);
    }

    public function reset(PokemonGoAPI $pokemonGoAPI)
    {
        $this->PokemonGoAPI = $pokemonGoAPI;
        $this->eggs = [];
    }

    public function addEgg(EggPokemon $egg)
    {
        $egg->setPokemonGoAPI($this->PokemonGoAPI);
        $this->eggs[] = $egg;
    }

    public function queryHatchedEggs()
    {
        $msg = new GetHatchedEggsMessage();
		$serverRequest = new ServerRequest(RequestType::GET_HATCHED_EGGS, $msg);
		$this->PokemonGoAPI->getRequestHandler()->sendServerRequests($serverRequest);

		$response = new GetHatchedEggsResponse($serverRequest->getData());

        $this->PokemonGoAPI->getInventories()->updateInventories();

		$eggs = [];
		for ($i = 0; $i < $response->getPokemonIdCount(); $i++) {
            $this->eggs[] = new HatchedEgg($response->getPokemonId($i),
                $response->getExperienceAwarded($i),
                $response->getCandyAwarded($i),
                $response->getStardustAwarded($i));
        }
		return $eggs;
    }
}