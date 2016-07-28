<?php
/**
 * User: tuttarealstep
 * Date: 28/07/16
 * Time: 19.14
 */

require realpath(__DIR__) . '/../vendor/autoload.php';

use PokemonGoAPI\Api\PokemonGoAPI;
use PokemonGoAPI\Auth\GoogleLogin;

class RenameEeveeExample
{
    public function run()
    {
        $PokemonGoAPILogin = (new GoogleLogin())->login('test@gmail.com', 'password');
        $PokemonGoAPI = new PokemonGoAPI($PokemonGoAPILogin);
        $PokemonGoAPI->getOutput()->setPKGODEBUG(true);

        $eevees = $PokemonGoAPI->getInventories()->getPokeBank()->getPokemonByPokemonId(\POGOProtos\Enums\PokemonId::EEVEE);

        $PokemonGoAPI->getOutput()->write("Hello " . $PokemonGoAPI->getPlayerProfile()->getUsername());

        $eeveesCount = count($eevees);

        if($eeveesCount > 0)
        {
            $eevees = array_values($eevees);
            $eevees[0]->renamePokemon("FooBar");
            $PokemonGoAPI->getOutput()->write("You have renamed Eevee!");
        } else {
            $PokemonGoAPI->getOutput()->write("You have no Eevee!");
        }
    }
}

$RenameEeveeExample = new RenameEeveeExample();
$RenameEeveeExample->run();