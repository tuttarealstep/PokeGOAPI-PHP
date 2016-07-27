<?php
/**
 * User: tuttarealstep
 * Date: 23/07/16
 * Time: 22.43
 */

namespace PokemonGoAPI\Main;

use GuzzleHttp\Client;
use POGOProtos\Networking\Envelopes\RequestEnvelope;
use POGOProtos\Networking\Envelopes\RequestEnvelope_AuthInfo;
use POGOProtos\Networking\Envelopes\RequestEnvelope_AuthInfo_JWT;
use POGOProtos\Networking\Envelopes\ResponseEnvelope;
use POGOProtos\Networking\Requests\Request;
use PokemonGoAPI\Api\PokemonGoAPI;

class RequestHandler
{
    private $requestOptions = [];
    private $requestId = null;

    private $PokemonGoAPI = null;
    public $userAuthToken = null;

    private $apiEndpoint = null;

    private $lastAuthTicket = null;

    function __construct(PokemonGoAPI $PokemonGoAPI, $userAuthToken)
    {
        $this->PokemonGoAPI = $PokemonGoAPI;
        $this->userAuthToken = $userAuthToken;

        $this->apiEndpoint = Settings::API_ENDPOINT;
        $this->requestId = rand(100000000, 999999999);
    }

    private function nextRequestId()
    {
        return $this->requestId++;
    }

    public function getRequestId()
    {
        return $this->requestId;
    }

    public function sendServerRequests(ServerRequest $request)
    {
        $requestEnvelope = new RequestEnvelope();
        $this->resetBuilder($requestEnvelope);

        $requestEnvelope->addAllRequests([$request->getRequest()]);

        $httpRequest = new Client([
            "headers" => ["User-Agent" => Settings::USER_AGENT]
        ]);
        $requestResponse = $httpRequest->post($this->apiEndpoint, ["body" => $requestEnvelope->toProtobuf()]);

        if($requestResponse->getStatusCode() != 200)
        {
            $this->PokemonGoAPI->getOutput()->write("Got a unexpected http code", false, $this->PokemonGoAPI->getOutput()->ERROR);
        }

        $responseEnvelope = new ResponseEnvelope((string) $requestResponse->getBody());

        if($responseEnvelope->getAuthTicket() != null)
        {
            $this->lastAuthTicket = $responseEnvelope->getAuthTicket();
            $this->PokemonGoAPI->getOutput()->write("Got Auth Ticket! ", false, $this->PokemonGoAPI->getOutput()->INFO);
        }

        if($responseEnvelope->getApiUrl() != null && count($responseEnvelope->getApiUrl()) > 0)
        {
            $this->apiEndpoint = "https://" .  $responseEnvelope->getApiUrl() . "/rpc";
            $this->PokemonGoAPI->getOutput()->write("Got apiEndpoint: " . $this->apiEndpoint, false, $this->PokemonGoAPI->getOutput()->INFO);
        }

        if($responseEnvelope->getStatusCode() == 53)
        {
            $this->PokemonGoAPI->getOutput()->write("Resend Request", false, $this->PokemonGoAPI->getOutput()->INFO);
            $this->sendServerRequests($request);
            return;
        }

        $count = 0;
        foreach($responseEnvelope->getReturnsArray() as $payload)
        {
            if($payload != null)
            {
                $request->handleData($payload);
            }
            $count++;
        }

        $this->nextRequestId();
    }


    private function resetBuilder(RequestEnvelope &$requestEnvelope)
    {
        $requestEnvelope->setStatusCode(2);
        $requestEnvelope->setRequestId($this->getRequestId());

        if ($this->lastAuthTicket != null && $this->lastAuthTicket->getExpireTimestampMs() > 0 && $this->lastAuthTicket->getExpireTimestampMs() > round(microtime(true) * 1000)) {
           $requestEnvelope->setAuthTicket($this->lastAuthTicket);
        } else {
            $authInfo = new RequestEnvelope_AuthInfo();
            $authInfo->setProvider($this->PokemonGoAPI->getUserProvider());
            $authToken = new RequestEnvelope_AuthInfo_JWT();
            $authToken->setContents($this->userAuthToken);
            $authToken->setUnknown2(59);
            $authInfo->setToken($authToken);
            $requestEnvelope->setAuthInfo($authInfo);
        }

        $requestEnvelope->setUnknown12(989);

        $requestEnvelope->setLatitude($this->PokemonGoAPI->getLatitude());
        $requestEnvelope->setLongitude($this->PokemonGoAPI->getLongitude());
        $requestEnvelope->setAltitude($this->PokemonGoAPI->getAltitude());
    }
}
