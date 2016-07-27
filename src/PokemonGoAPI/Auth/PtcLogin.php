<?php
/**
 * User: tuttarealstep
 * Date: 27/07/16
 * Time: 22.47
 */

namespace PokemonGoAPI\Auth;

use GuzzleHttp\Client;
use PokemonGoAPI\Utils\Output;

class PtcLogin extends Login
{

    private $CLIENT_SECRET = "w8ScCUXJQc6kXKw8FiOhd8Fixzht18Dq3PEVkUCP5ZPxtgyWsbTvWHFLm2wNY0JR";
    private $REDIRECT_URI = "https://www.nianticlabs.com/pokemongo/error";
    private $CLIENT_ID = "mobile-app_pokemon-go";
    private $API_URL = "https://pgorelease.nianticlabs.com/plfe/rpc";
    private $LOGIN_URL = "https://sso.pokemon.com/sso/login?service=https%3A%2F%2Fsso.pokemon.com%2Fsso%2Foauth2.0%2FcallbackAuthorize";
    private $LOGIN_OAUTH = "https://sso.pokemon.com/sso/oauth2.0/accessToken";
    private $USER_AGENT = "niantic";

    function __construct()
    {
        $this->setOutput(new Output());
    }

    public function login($username, $password)
    {
        //TODO PTC Login
    }
}