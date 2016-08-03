<?php

use PokemonGoAPI\Api\PokemonGoAPI;

/**
 * Class BaseExample
 */
abstract class BaseExample
{
    /**
     * @var PokemonGoAPI
     */
    protected $api;

    /**
     * BaseExample constructor.
     */
    public function __construct()
    {
        $dotenv = new Dotenv\Dotenv(__DIR__);
        $dotenv->load();

        $googleLogin = new \PokemonGoAPI\Auth\GoogleLogin();

        $loginData = ($token = @file_get_contents('.token')) ?
            $googleLogin->loginWithGoogleToken($token) : // login with existing token
            $googleLogin->login(getenv('EMAIL'), getenv('PASSWORD')); // or by pair email/password

        file_put_contents('.token', $loginData['Auth']);

        $this->api = new PokemonGoAPI($loginData);
        $this->api->getOutput()->setPKGODEBUG(true);
    }

    abstract public function run();
}