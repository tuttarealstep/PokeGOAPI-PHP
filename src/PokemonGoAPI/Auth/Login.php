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

    /**
     * Function for set the output class (useful for print)
     * @param $output
     */
    protected function setOutput($output)
    {
        $this->output = $output;
    }

    /**
     * Return the Output class
     * @return mixed
     */
    protected function getOutput()
    {
        return $this->output;
    }

    /**
     * Login function
     *
     * @param $username
     * @param $password
     * @return mixed
     */
    abstract public function login($username, $password);
}