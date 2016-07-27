<?php
/**
 * User: tuttarealstep
 * Date: 27/07/16
 * Time: 23.17
 */


require realpath(__DIR__) . '/../vendor/autoload.php';

use PokemonGoAPI\Api\PokemonGoAPI;

class GoogleLoginExample
{
    public function run()
    {
        $PokemonGoAPILogin = (new \PokemonGoAPI\Auth\GoogleLogin())->login('test@gmail.com', 'password');
        $PokemonGoAPI = new PokemonGoAPI($PokemonGoAPILogin);
        print_r($PokemonGoAPI->getPlayerProfile()->getUsername() . "\n");
    }
}

$GoogleLoginExample = new GoogleLoginExample();
$GoogleLoginExample->run();