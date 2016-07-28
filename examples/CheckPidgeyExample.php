<?php
/**
 * User: tuttarealstep
 * Date: 28/07/16
 * Time: 15.38
 */

require realpath(__DIR__) . '/../vendor/autoload.php';

use PokemonGoAPI\Api\PokemonGoAPI;

class CheckPidgeyExample
{
    public function run()
    {
        $PokemonGoAPILogin = (new \PokemonGoAPI\Auth\GoogleLogin())->login('test@gmail.com', 'password');
        $PokemonGoAPI = new PokemonGoAPI($PokemonGoAPILogin);
        $PokemonGoAPI->getOutput()->setPKGODEBUG(true);

        $pidgeys = $PokemonGoAPI->getInventories()->getPokeBank()->getPokemonByPokemonId(\POGOProtos\Enums\PokemonId::PIDGEY);

        $PokemonGoAPI->getOutput()->write("Hello " . $PokemonGoAPI->getPlayerProfile()->getUsername());

        $pidgeysCount = count($pidgeys);

        if($pidgeysCount > 0)
        {
            $PokemonGoAPI->getOutput()->write("You have : " . $pidgeysCount  . " pidgeys");
        } else {
            $PokemonGoAPI->getOutput()->write("You have no pidgeys!");
        }
    }
}

$CheckPidgeyExample = new CheckPidgeyExample();
$CheckPidgeyExample->run();