<?php
/**
 * User: tuttarealstep
 * Date: 28/07/16
 * Time: 15.38
 */

require '../vendor/autoload.php';
require  'BaseExample.php';

class CheckPidgeyExample extends BaseExample
{
    public function run()
    {
        $pidgeys = $this->api->getInventories()->getPokeBank()->getPokemonByPokemonId(\POGOProtos\Enums\PokemonId::PIDGEY);

        $this->api->getOutput()->write("Hello " . $this->api->getPlayerProfile()->getUsername());

        $pidgeysCount = count($pidgeys);

        if ($pidgeysCount > 0) {
            $this->api->getOutput()->write("You have : " . $pidgeysCount . " pidgeys");
        } else {
            $this->api->getOutput()->write("You have no pidgeys!");
        }
    }
}

$CheckPidgeyExample = new CheckPidgeyExample();
$CheckPidgeyExample->run();