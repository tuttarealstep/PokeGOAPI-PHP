<?php
/**
 * User: tuttarealstep
 * Date: 23/07/16
 * Time: 18.48
 */

namespace PokemonGoAPI\Auth;

use GuzzleHttp\Client;
use PokemonGoAPI\Utils\Output;

class GoogleLogin extends Login
{
    /*private $secret = "NCjF1TLi2CcY6t5mt0ZveuL7";
    private $clientId = "848232511240-73ri3t7plvk96pj4f85uj8otdat2alem.apps.googleusercontent.com";
    private $oauthEndPoint = "https://accounts.google.com/o/oauth2/device/code";
    private $oauthTokenEndPoint = "https://www.googleapis.com/oauth2/v4/token";*/

    private $androidId = "3764d56d68ae549c";
    private $oauthService = "audience:server:client_id:848232511240-7so421jotr2609rmqakceuu1luuq0ptb.apps.googleusercontent.com";
    private $nianticApp = "com.nianticlabs.pokemongo";
    private $clientId = "321187995bc7cdc2b5fc91b11a96e2baa8602c62";

    private $oauthClient = null;

    /**
     * GoogleLogin constructor.
     *
     * Setup for client request
     */
    function __construct()
    {
        $this->setOutput(new Output());

        $this->oauthClient = new Client(
            [
                "base_uri" => "https://android.clients.google.com",
                "headers" => ["User-Agent" => "API"]
            ]
        );
    }

    /**
     * You pass username and password and it return the user token
     *
     * @param $username
     * @param $password
     * @return array|bool
     */
    public function login($username, $password)
    {
        $this->getOutput()->write("Initialize Google Login", false, $this->getOutput()->INFO);
        $googleLogin = $this->oauthClient->post("auth",
            [
                "form_params" => [
                    "accountType"     => "HOSTED_OR_GOOGLE",
                    "Email"           => $username,
                    "has_permission"  => 1,
                    "add_account"     => 1,
                    "Passwd"          => $password,
                    "service"         => "ac2dm",
                    "source"          => "android",
                    "androidId"       => $this->androidId,
                    "device_country"  => "us",
                    "operatorCountry" => "us",
                    "lang"            => "en",
                    "sdk_version"     => 17
                ]
            ]);

        $googleLogin = parse_ini_string($googleLogin->getBody());

        if (!isset($googleLogin["Token"]))
        {
            $this->getOutput()->write("Error Google Login", false, $this->getOutput()->ERROR);
            return false;
        }

        $googleOAuthLogin = $this->oauthClient->post("auth",
            [
                "form_params" => [
                "accountType"     => "HOSTED_OR_GOOGLE",
                "Email"           => $username,
                "has_permission"  => 1,
                "EncryptedPasswd" => $googleLogin['Token'],
                "service"         => $this->oauthService,
                "source"          => "android",
                "androidId"       => $this->androidId,
                "app"             => $this->nianticApp,
                "client_sig"      => $this->clientId,
                "device_country"  => "it",
                "operatorCountry" => "it",
                "lang"            => "en",
                "sdk_version"     => 17
            ]]
        );

        $googleOAuthLogin = parse_ini_string($googleOAuthLogin->getBody());

        if (!isset($googleOAuthLogin['Auth']))
        {
            $this->getOutput()->write("Error s Google Login", false, $this->getOutput()->ERROR);
            return false;
        }

        return $this->loginWithGoogleToken($googleOAuthLogin['Auth']);
    }

    /**
     * @param string $token
     *
     * @return array
     */
    public function loginWithGoogleToken($token)
    {
        return ["Auth" => $token, "Provider" => "google"];
    }
}