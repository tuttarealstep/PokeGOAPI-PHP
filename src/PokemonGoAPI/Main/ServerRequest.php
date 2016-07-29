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

    /**
     * ServerRequest constructor.
     *
     * It require a request type and a message
     * The request type is a request like: GET_PLAYER
     * you can find all request in POGOProtos\Networking\Requests
     * The message is a container with all information required
     *
     * @param $type
     * @param null $message
     */
    function __construct($type, $message = null)
    {
        $requestOuterClass = new Request();
        $requestOuterClass->setRequestType($type);
        $requestOuterClass->setRequestMessage($message->toProtobuf());

        $this->request = $requestOuterClass;
        $this->requestType = $type;
    }

    /**
     * Return the request
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Function for handle data from RequestHandler and set it into $data variable
     *
     * @param $data
     */
    public function handleData($data)
    {
        $this->data = $data;
    }

    /**
     * Return $data variable
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}