<?php
/**
 * User: tuttarealstep
 * Date: 29/07/16
 * Time: 10.59
 */

require '../vendor/autoload.php';
require 'BaseExample.php';

class CatchPokemonAtAreaExample extends BaseExample
{
    public function run()
    {
        /*
         * If you want use the print class set the debug od the output class to true
         */
        $this->api->getOutput()->setPKGODEBUG(true);

        /*
         * Set the user coordinate, if you don't set these the api use its default coordinates
         */
        $this->api->setLocation(-32.058087, 115.744325, 0);

        /*
         * Print with output class the user username
         */
        $this->api->getOutput()->write("Hello " . $this->api->getPlayerProfile()->getUsername());

        /*
         * Get the map object
         */
        $map = $this->api->getMap();

        /*
         * Print the number of pokemon in the area by using the function getCatchablePokemon()
         * that return an array with all catchable pokemon in the area, for count how much pokemon
         * use the simple php function count()
         */
        $catchablePokemons = $map->getCatchablePokemon();
        $this->api->getOutput()->write("Pokemon in area:  " . count($catchablePokemons));

        /*
         * Iterate the catchable pokemon array
         */
        foreach ($catchablePokemons as $CatchablePokemon) {

            /*
             * Return the encounter pokemon
             */
            $encResult = $CatchablePokemon->encounterPokemon();

            /*
             * Check the encounter
             */
            if ($encResult->wasSuccessful()) {
                /* Writhe the founded pokemon name */
                $this->api->getOutput()->write("Encounted: " . $CatchablePokemon->getPokemonName());

                /* Try to catch the pokemon  */
                $result = $CatchablePokemon->catchPokemon();
                $this->api->getOutput()->write("Attempt to catch: " . $CatchablePokemon->getPokemonName() . " " . $result->getStatus());
            }
        }
    }
}

$CatchPokemonAtAreaExample = new CatchPokemonAtAreaExample();
$CatchPokemonAtAreaExample->run();