<?php
/**
 * User: tuttarealstep
 * Date: 28/07/16
 * Time: 19.14
 */

require realpath(__DIR__) . '/../vendor/autoload.php';

use PokemonGoAPI\Api\PokemonGoAPI;

class GetCatchablePokemonInAreaExample
{
    public function run()
    {
        $PokemonGoAPILogin = (new \PokemonGoAPI\Auth\GoogleLogin())->login('test@gmail.com', 'password');
        $PokemonGoAPI = new PokemonGoAPI($PokemonGoAPILogin);
        $PokemonGoAPI->getOutput()->setPKGODEBUG(true);

        $PokemonGoAPI->getOutput()->write("Hello " . $PokemonGoAPI->getPlayerProfile()->getUsername());

        $map = $PokemonGoAPI->getMap();
        //var_dump($map->getCatchablePokemon());

        $PokemonGoAPI->getOutput()->write("Pokemon in area:  " . count($map->getCatchablePokemon()));
    }
}

$GetCatchablePokemonInAreaExample = new GetCatchablePokemonInAreaExample();
$GetCatchablePokemonInAreaExample->run();