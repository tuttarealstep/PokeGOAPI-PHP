<?php
/**
 * User: tuttarealstep
 * Date: 27/07/16
 * Time: 23.17
 */


require '../vendor/autoload.php';

use PokemonGoAPI\Api\PokemonGoAPI;

class GoogleLoginExample
{
    public function run()
    {
        $PokemonGoAPILogin = (new \PokemonGoAPI\Auth\GoogleLogin())->login('test@gmail.com', 'password');
        $PokemonGoAPI      = new PokemonGoAPI($PokemonGoAPILogin);
        $PokemonGoAPI->getOutput()->setPKGODEBUG(true);
        $PokemonGoAPI->getOutput()->write($PokemonGoAPI->getPlayerProfile()->getUsername());
    }
}

$GoogleLoginExample = new GoogleLoginExample();
$GoogleLoginExample->run();