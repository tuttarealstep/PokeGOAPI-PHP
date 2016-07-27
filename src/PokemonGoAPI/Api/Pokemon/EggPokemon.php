<?php
/**
 * User: tuttarealstep
 * Date: 27/07/16
 * Time: 20.38
 */

namespace PokemonGoAPI\Api\Pokemon;


use POGOProtos\Data\PokemonData;
use PokemonGoAPI\Api\Inventory\EggIncubator;
use PokemonGoAPI\Api\PokemonGoAPI;

class EggPokemon
{
    private $PokemonGoAPI = null;
    private $pokemonData = null;

    function __construct(PokemonData $pokemonData)
    {
        $this->pokemonData = $pokemonData;
    }

    function setPokemonGoAPI(PokemonGoAPI $pokemonGoAPI)
    {
        $this->PokemonGoAPI = $pokemonGoAPI;
    }

    public function incubate(EggIncubator $incubator)
    {
        if($incubator->isInUse())
        {
            throw new \Exception("Incubator already used");
        }

        return $incubator->hatchEgg($this);
    }

    public function getEggKmWalked()
    {
        if($this->isIncubate())
            return 0;

        $incubator = array_filter($this->PokemonGoAPI->getInventories()->getIncubators(), function(EggIncubator $incubator)
        {
            if($incubator->getId() == $this->pokemonData->getEggIncubatorId())
            {
                return true;
            }

            return false;
        });

        if($incubator == null)
        {
            return 0;
        } else {
            return $this->pokemonData->getEggKmWalkedTarget() - ($incubator->getKmTarget() - $this->PokemonGoAPI->getPlayerProfile()->getStats()->getKmWalked());
        }
    }

public function getId() {
return $this->pokemonData->getId();
}

public function getEggKmWalkedTarget() {
		return $this->pokemonData->getEggKmWalkedTarget();
	}

	public function getCapturedCellId() {
		return $this->pokemonData->getCapturedCellId();
	}

	public function getCreationTimeMs() {
		return $this->pokemonData->getCreationTimeMs();
	}

	public function getEggIncubatorId() {
		return $this->pokemonData->getEggIncubatorId();
	}

	public function isIncubate() {
		return count($this->pokemonData->getEggIncubatorId()) > 0;
	}
    
}