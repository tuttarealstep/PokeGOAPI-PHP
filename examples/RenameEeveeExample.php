<?php
/**
 * User: tuttarealstep
 * Date: 28/07/16
 * Time: 19.14
 */

require '../vendor/autoload.php';
require  'BaseExample.php';

use PokemonGoAPI\Api\PokemonGoAPI;
use PokemonGoAPI\Auth\GoogleLogin;

class RenameEeveeExample extends BaseExample
{
    public function run()
    {
        $eevees = $this->api
            ->getInventories()
            ->getPokeBank()
            ->getPokemonByPokemonId(\POGOProtos\Enums\PokemonId::STARYU);

        $this->api->getOutput()->write("Hello " . $this->api->getPlayerProfile()->getUsername());

        $eeveesCount = count($eevees);

        if ($eeveesCount > 0) {
            $pokemon = current($eevees);
            $pokemon->renamePokemon("FooBar");
            $this->api->getOutput()->write("You have renamed Eevee!");
        } else {
            $this->api->getOutput()->write("You have no Eevee!");
        }
    }
}

$RenameEeveeExample = new RenameEeveeExample();
$RenameEeveeExample->run();