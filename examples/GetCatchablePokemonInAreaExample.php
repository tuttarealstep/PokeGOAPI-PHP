<?php
/**
 * User: tuttarealstep
 * Date: 28/07/16
 * Time: 19.14
 */

require '../vendor/autoload.php';
require 'BaseExample.php';

class GetCatchablePokemonInAreaExample extends BaseExample
{
    public function run()
    {
        $this->api->getOutput()->write("Hello " . $this->api->getPlayerProfile()->getUsername());

        $map = $this->api->getMap();

        $pokemons = $map->getCatchablePokemon();
        $this->api->getOutput()->write("Pokemon in area:  " . count($pokemons));

        foreach ($pokemons as $id => $pokemon) {
            $msg = sprintf('%s pokemon located at %s, %s', $pokemon->getPokemonName(), $pokemon->getLatitude(),
                $pokemon->getLongitude());
            $this->api->getOutput()->write($msg);
        }
    }
}

$GetCatchablePokemonInAreaExample = new GetCatchablePokemonInAreaExample();
$GetCatchablePokemonInAreaExample->run();