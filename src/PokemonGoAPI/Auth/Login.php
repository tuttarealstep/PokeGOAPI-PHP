<?php
/**
 * User: tuttarealstep
 * Date: 23/07/16
 * Time: 18.47
 */

namespace PokemonGoAPI\Auth;

abstract class Login
{
    private $output;


    protected function setOutput($output)
    {
        $this->output = $output;
    }

    protected function getOutput()
    {
        return $this->output;
    }

    abstract public function login($username, $password);
}