# PokeGOAPI-PHP
Pokemon GO PHP API library

This is a conversion of this: [PokeGOAPI-Java](https://github.com/Grover-c13/PokeGOAPI-Java) in php.

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

For enable debug message go to ``src/PokemonGoAPI/Utils/Output.php`` and change:
```php
    public $PK_GO_DEBUG = false;
 ```

To:

```php
    public $PK_GO_DEBUG = true;
 ```

## Problems
- If you get NeedsBrowser error go to this link: [DisplayUnlockCaptcha](https://accounts.google.com/b/0/DisplayUnlockCaptcha) and proceed to Unlock captcha.
## Links
  - [Examples](https://github.com/tuttarealstep/PokeGOAPI-PHP/tree/master/examples)

## Todo
  - Implement PTC Login
  - Test all things
  - Check for issues
  - Comment code
  - Phpdoc
  - Guide

## Credits
- [Grover-c13](https://github.com/Grover-c13) for his java api (Beacuse I've converted his api in php and for the inspiration)
- [jaspervdm](https://github.com/jaspervdm/pogoprotos-php) for his protos
- [NicklasWallgren](https://github.com/NicklasWallgren/PokemonGoAPI-PHP) because I've used for his updated protos

## Legal
This project is in no way affiliated with, maintained, sponsored, authorized by Niantic, The Pokémon Company, Nintendo or any of its affiliates or subsidiaries. This is an independent and unofficial API for educational use ONLY. Using the project might be against the terms of service.