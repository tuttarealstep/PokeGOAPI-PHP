<?php
/**
 * User: tuttarealstep
 * Date: 23/07/16
 * Time: 18.49
 */

namespace PokemonGoAPI\Utils;

class Output
{
    private $buffer = "";

    public $NONE = 0;
    public $INFO = 1;
    public $WARNING = 2;
    public $ERROR = 3;

    /**
     * If true print
     * @var bool
     */
    public $PK_GO_DEBUG = false;

    /**
     * Useful function for print in terminal
     *
     * If $buffer = true it add the message in the global buffer variable.
     * The $level variable can have an int value from 0 to 3 for write with different style
     * If $newLine = true it automatically add a new line after the message
     *
     * @param $message
     * @param bool $buffer
     * @param int $level
     * @param bool $newLine
     * @return bool
     */
    public function write($message, $buffer = false, $level = 0, $newLine = true)
    {
        if($this->PK_GO_DEBUG == false)
            return false;

        if(empty($message))
            return false;

        $outMsg = "[-] ";

        switch($level)
        {
            case $this->INFO:
                $outMsg = "[i] ";
                break;
            case $this->WARNING:
                $outMsg = "[!] ";
                break;
            case $this->ERROR:
                $outMsg = "[x] ";
                break;
        }

        $outMsg .= $message;

        if($newLine)
            $outMsg .= "\n";

        if($buffer == false)
        {
            echo $outMsg;
            return true;
        } else {
            $this->addToBuffer($outMsg);
            return true;
        }
    }

    /**
     * For clear buffer
     */
    public function clearBuffer()
    {
        $this->buffer = "";
    }

    /**
     * For add a custom message to buffer without pass it into write() function.
     *
     * @param $message
     */
    public function addToBuffer($message)
    {
        $this->buffer .= $message;
    }

    /**
     * Return the buffer variable
     *
     * @return string
     */
    public function getBuffer()
    {
        return $this->buffer;
    }

    /**
     * Print the buffer variable
     */
    public function printBuffer()
    {
        echo $this->buffer;
        $this->clearBuffer();
    }

    /**
     * Function to set PK_GO_DEBUG variable for enable print or disable
     *
     * @param $PK_GO_DEBUG
     */
    public function setPKGODEBUG($PK_GO_DEBUG)
    {
        $this->PK_GO_DEBUG = $PK_GO_DEBUG;
    }
}