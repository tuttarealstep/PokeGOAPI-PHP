<?php
/**
 * User: tuttarealstep
 * Date: 29/07/16
 * Time: 10.59
 */


require realpath(__DIR__) . '/../vendor/autoload.php';

use PokemonGoAPI\Api\PokemonGoAPI;

class CatchPokemonAtAreaExample
{
    public function run()
    {
        $PokemonGoAPILogin = (new \PokemonGoAPI\Auth\GoogleLogin())->login('test@gmail.com', 'password');
        $PokemonGoAPI = new PokemonGoAPI($PokemonGoAPILogin);
        $PokemonGoAPI->getOutput()->setPKGODEBUG(true);

        $PokemonGoAPI->setLocation(-32.058087, 115.744325, 0);

        $PokemonGoAPI->getOutput()->write("Hello " . $PokemonGoAPI->getPlayerProfile()->getUsername());

        $map = $PokemonGoAPI->getMap();

        $PokemonGoAPI->getOutput()->write("Pokemon in area:  " . count($map->getCatchablePokemon()));

        foreach($map->getCatchablePokemon() as $CatchablePokemon)
        {
            $encResult = $CatchablePokemon->encounterPokemon();
            if ($encResult->wasSuccessful()) {
                $PokemonGoAPI->getOutput()->write("Encounted: " . $CatchablePokemon->getPokemonId());
                $result = $CatchablePokemon->catchPokemon();
                $PokemonGoAPI->getOutput()->write("Attempt to catch: " . $CatchablePokemon->getPokemonId() . " " . $result->getStatus());
            }
        }
    }
}

$CatchPokemonAtAreaExample = new CatchPokemonAtAreaExample();
$CatchPokemonAtAreaExample->run();