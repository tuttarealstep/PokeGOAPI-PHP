<?php
/**
 * User: tuttarealstep
 * Date: 25/07/16
 * Time: 11.40
 */

namespace PokemonGoAPI\Main;

use POGOProtos\Networking\Requests\Request;
use POGOProtos\Networking\Requests\RequestType;

class ServerRequest
{
    private $request;
    private $requestType;
    private $data;

    function __construct($type, $message = null)
    {
        $requestOuterClass = new Request();
        $requestOuterClass->setRequestType($type);
        $requestOuterClass->setRequestMessage($message);

        $this->request = $requestOuterClass;
        $this->requestType = $type;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function handleData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }
}