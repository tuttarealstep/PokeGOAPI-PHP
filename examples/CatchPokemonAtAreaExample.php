<?php
/**
 * User: tuttarealstep
 * Date: 29/07/16
 * Time: 10.59
 */


require realpath(__DIR__) . '/../vendor/autoload.php';

use PokemonGoAPI\Api\PokemonGoAPI;

class CatchPokemonAtAreaExample
{
    public function run()
    {
        /*
         * Your user need signin by pass his username(email) and password to the login function.
         * After the login the function return an array with the user token and provider (google in this case)
         */
        $PokemonGoAPILogin = (new \PokemonGoAPI\Auth\GoogleLogin())->login('test@gmail.com', 'password');

        /*
         * Send the array with the token and the provider to the api
         */
        $PokemonGoAPI = new PokemonGoAPI($PokemonGoAPILogin);

        /*
         * If you want use the print class set the debug od the output class to true
         */
        $PokemonGoAPI->getOutput()->setPKGODEBUG(true);

        /*
         * Set the user coordinate, if you don't set these the api use its default coordinates
         */
        $PokemonGoAPI->setLocation(-32.058087, 115.744325, 0);

        /*
         * Print with output class the user username
         */
        $PokemonGoAPI->getOutput()->write("Hello " . $PokemonGoAPI->getPlayerProfile()->getUsername());

        /*
         * Get the map object
         */
        $map = $PokemonGoAPI->getMap();

        /*
         * Print the number of pokemon in the area by using the function getCatchablePokemon()
         * that return an array with all catchable pokemon in the area, for count how much pokemon
         * use the simple php function count()
         */
        $PokemonGoAPI->getOutput()->write("Pokemon in area:  " . count($map->getCatchablePokemon()));

        /*
         * Iterate the catchable pokemon array
         */
        foreach($map->getCatchablePokemon() as $CatchablePokemon)
        {
            /*
             * Return the encounter pokemon
             */
            $encResult = $CatchablePokemon->encounterPokemon();

            /*
             * Check the encounter
             */
            if ($encResult->wasSuccessful()) {
                /* Writhe the founded pokemon id */
                $PokemonGoAPI->getOutput()->write("Encounted: " . $CatchablePokemon->getPokemonId());

                /* Try to catch the pokemon  */
                $result = $CatchablePokemon->catchPokemon();
                $PokemonGoAPI->getOutput()->write("Attempt to catch: " . $CatchablePokemon->getPokemonId() . " " . $result->getStatus());
            }
        }
    }
}

$CatchPokemonAtAreaExample = new CatchPokemonAtAreaExample();
$CatchPokemonAtAreaExample->run();