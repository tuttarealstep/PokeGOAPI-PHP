# PokeGOAPI-PHP
Pokemon GO PHP API library

# Build
  - Clone the repo
  - `` git clone https://github.com/tuttarealstep/PokeGOAPI-PHP.git ``
  - Move to the repo folder
  - `` cd PokeGOAPI-PHP ``
  - Install the dependencies
  - `` composer install ``

# Usage
How to use example:

```php
  use PokemonGoAPI\Api\PokemonGoAPI;
  
  $PokemonGoAPILogin = (new \PokemonGoAPI\Auth\GoogleLogin())->login('username', 'password'); //Use Google for login and retrive token
  
  $PokemonGoAPI = new PokemonGoAPI($PokemonGoAPILogin); //Send token to the api
  
  echo $PokemonGoAPI->getPlayerProfile()->getUsername() . "\n"; //Print User Username
```

## TODO
  - Implement PTC Login
  - Finish Map Implementation
  - Test all things

## Credits
- [Grover-c13](https://github.com/Grover-c13) for his java api (Beacuse I've converted his api in php and for the inspiration)
- [jaspervdm](https://github.com/jaspervdm/pogoprotos-php) for his protos
- [NicklasWallgren](https://github.com/NicklasWallgren/PokemonGoAPI-PHP) because I've used for his updated protos
