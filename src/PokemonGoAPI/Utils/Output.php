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
    public $PK_GO_DEBUG = false;

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

    public function clearBuffer()
    {
        $this->buffer = "";
    }

    public function addToBuffer($message)
    {
        $this->buffer .= $message;
    }

    public function getBuffer()
    {
        return $this->buffer;
    }

    public function printBuffer()
    {
        echo $this->buffer;
        $this->clearBuffer();
    }
}