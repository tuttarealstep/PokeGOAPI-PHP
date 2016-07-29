<?php
/**
 * User: tuttarealstep
 * Date: 26/07/16
 * Time: 0.04
 */

namespace PokemonGoAPI\Api\Pokemon;

use POGOProtos\Enums\PokemonFamilyId;
use POGOProtos\Enums\PokemonId;

class PokemonMetaRegistry
{
    /**
     * All pokemon family
     *
     * @var array
     */
    private static $familys = [
        PokemonFamilyId::FAMILY_BULBASAUR => [
            PokemonId::BULBASAUR,
            PokemonId::IVYSAUR,
            PokemonId::VENUSAUR
        ],
        PokemonFamilyId::FAMILY_CHARMANDER => [
            PokemonId::CHARMANDER,
            PokemonId::CHARMELEON,
            PokemonId::CHARIZARD
        ],
        PokemonFamilyId::FAMILY_SQUIRTLE => [
            PokemonId::SQUIRTLE,
            PokemonId::WARTORTLE,
            PokemonId::BLASTOISE
        ],
        PokemonFamilyId::FAMILY_CATERPIE => [
            PokemonId::CATERPIE,
            PokemonId::METAPOD,
            PokemonId::BUTTERFREE
        ],
        PokemonFamilyId::FAMILY_WEEDLE => [
            PokemonId::WEEDLE,
            PokemonId::KAKUNA,
            PokemonId::BEEDRILL
        ],
        PokemonFamilyId::FAMILY_PIDGEY => [
            PokemonId::PIDGEY,
            PokemonId::PIDGEOTTO,
            PokemonId::PIDGEOT
        ],
        PokemonFamilyId::FAMILY_RATTATA => [
            PokemonId::RATTATA,
            PokemonId::RATICATE
        ],
        PokemonFamilyId::FAMILY_SPEAROW => [
            PokemonId::SPEAROW,
            PokemonId::FEAROW
        ],
        PokemonFamilyId::FAMILY_EKANS => [
            PokemonId::EKANS,
            PokemonId::ARBOK
        ],
        PokemonFamilyId::FAMILY_PIKACHU => [
            PokemonId::PIKACHU,
            PokemonId::RAICHU
        ],
        PokemonFamilyId::FAMILY_SANDSHREW => [
            PokemonId::SANDSHREW,
            PokemonId::SANDSLASH
        ],
        PokemonFamilyId::FAMILY_NIDORAN_FEMALE => [
            PokemonId::NIDORAN_FEMALE,
            PokemonId::NIDORINA,
            PokemonId::NIDOQUEEN
        ],
        PokemonFamilyId::FAMILY_NIDORAN_MALE => [
            PokemonId::NIDORAN_MALE,
            PokemonId::NIDORINO,
            PokemonId::NIDOKING
        ],
        PokemonFamilyId::FAMILY_CLEFAIRY => [
            PokemonId::CLEFAIRY,
            PokemonId::CLEFABLE
        ],
        PokemonFamilyId::FAMILY_VULPIX => [
            PokemonId::VULPIX,
            PokemonId::NINETALES
        ],
        PokemonFamilyId::FAMILY_JIGGLYPUFF => [
            PokemonId::JIGGLYPUFF,
            PokemonId::WIGGLYTUFF
        ],
        PokemonFamilyId::FAMILY_ZUBAT => [
            PokemonId::ZUBAT,
            PokemonId::GOLBAT
        ],
        PokemonFamilyId::FAMILY_ODDISH => [
            PokemonId::ODDISH,
            PokemonId::GLOOM,
            PokemonId::VILEPLUME
        ],
        PokemonFamilyId::FAMILY_PARAS => [
            PokemonId::PARAS,
            PokemonId::PARASECT
        ],
        PokemonFamilyId::FAMILY_VENONAT => [
            PokemonId::VENONAT,
            PokemonId::VENOMOTH
        ],
        PokemonFamilyId::FAMILY_DIGLETT => [
            PokemonId::DIGLETT,
            PokemonId::DUGTRIO
        ],
        PokemonFamilyId::FAMILY_MEOWTH => [
            PokemonId::MEOWTH,
            PokemonId::PERSIAN
        ],
        PokemonFamilyId::FAMILY_PSYDUCK => [
            PokemonId::PSYDUCK,
            PokemonId::GOLDUCK
        ],
        PokemonFamilyId::FAMILY_MANKEY => [
            PokemonId::MANKEY,
            PokemonId::PRIMEAPE
        ],
        PokemonFamilyId::FAMILY_GROWLITHE => [
            PokemonId::GROWLITHE,
            PokemonId::ARCANINE
        ],
        PokemonFamilyId::FAMILY_POLIWAG => [
            PokemonId::POLIWAG,
            PokemonId::POLIWHIRL,
            PokemonId::POLIWRATH
        ],
        PokemonFamilyId::FAMILY_ABRA => [
            PokemonId::ABRA,
            PokemonId::KADABRA,
            PokemonId::ALAKAZAM
        ],
        PokemonFamilyId::FAMILY_MACHOP => [
            PokemonId::MACHOP,
            PokemonId::MACHOKE,
            PokemonId::MACHAMP
        ],
        PokemonFamilyId::FAMILY_BELLSPROUT => [
            PokemonId::BELLSPROUT,
            PokemonId::WEEPINBELL,
            PokemonId::VICTREEBEL
        ],
        PokemonFamilyId::FAMILY_TENTACOOL => [
            PokemonId::TENTACOOL,
            PokemonId::TENTACRUEL
        ],
        PokemonFamilyId::FAMILY_GEODUDE => [
            PokemonId::GEODUDE,
            PokemonId::GRAVELER,
            PokemonId::GOLEM
        ],
        PokemonFamilyId::FAMILY_PONYTA => [
            PokemonId::PONYTA,
            PokemonId::RAPIDASH
        ],
        PokemonFamilyId::FAMILY_SLOWPOKE => [
            PokemonId::SLOWPOKE,
            PokemonId::SLOWBRO
        ],
        PokemonFamilyId::FAMILY_MAGNEMITE => [
            PokemonId::MAGNEMITE,
            PokemonId::MAGNETON
        ],
        PokemonFamilyId::FAMILY_FARFETCHD => [
            PokemonId::FARFETCHD
        ],
        PokemonFamilyId::FAMILY_DODUO => [
            PokemonId::DODUO,
            PokemonId::DODRIO
        ],
        PokemonFamilyId::FAMILY_SEEL => [
            PokemonId::SEEL,
            PokemonId::DEWGONG
        ],
        PokemonFamilyId::FAMILY_GRIMER => [
            PokemonId::GRIMER,
            PokemonId::MUK
        ],
        PokemonFamilyId::FAMILY_SHELLDER => [
            PokemonId::SHELLDER,
            PokemonId::CLOYSTER
        ],
        PokemonFamilyId::FAMILY_GASTLY => [
            PokemonId::GASTLY,
            PokemonId::HAUNTER,
            PokemonId::GENGAR
        ],
        PokemonFamilyId::FAMILY_ONIX => [
            PokemonId::ONIX
        ],
        PokemonFamilyId::FAMILY_DROWZEE => [
            PokemonId::DROWZEE
        ],
        PokemonFamilyId::FAMILY_KRABBY => [
            PokemonId::KRABBY,
            PokemonId::KINGLER
        ],
        PokemonFamilyId::FAMILY_VOLTORB => [
            PokemonId::VOLTORB,
            PokemonId::ELECTRODE
        ],
        PokemonFamilyId::FAMILY_EXEGGCUTE => [
            PokemonId::EXEGGCUTE,
            PokemonId::EXEGGUTOR
        ],
        PokemonFamilyId::FAMILY_CUBONE => [
            PokemonId::CUBONE,
            PokemonId::MAROWAK
        ],
        PokemonFamilyId::FAMILY_HITMONLEE => [
            PokemonId::HITMONLEE
        ],
        PokemonFamilyId::FAMILY_HITMONCHAN => [
            PokemonId::HITMONCHAN
        ],
        PokemonFamilyId::FAMILY_LICKITUNG => [
            PokemonId::LICKITUNG
        ],
        PokemonFamilyId::FAMILY_KOFFING => [
            PokemonId::KOFFING,
            PokemonId::WEEZING
        ],
        PokemonFamilyId::FAMILY_RHYHORN => [
            PokemonId::RHYHORN,
            PokemonId::RHYDON
        ],
        PokemonFamilyId::FAMILY_CHANSEY => [
            PokemonId::CHANSEY
        ],
        PokemonFamilyId::FAMILY_TANGELA => [
            PokemonId::TANGELA
        ],
        PokemonFamilyId::FAMILY_KANGASKHAN => [
            PokemonId::KANGASKHAN
        ],
        PokemonFamilyId::FAMILY_HORSEA => [
            PokemonId::HORSEA,
            PokemonId::SEADRA
        ],
        PokemonFamilyId::FAMILY_GOLDEEN => [
            PokemonId::GOLDEEN,
            PokemonId::SEAKING
        ],
        PokemonFamilyId::FAMILY_STARYU => [
            PokemonId::STARYU,
            PokemonId::STARMIE
        ],
        PokemonFamilyId::FAMILY_MR_MIME => [
            PokemonId::MR_MIME
        ],
        PokemonFamilyId::FAMILY_SCYTHER => [
            PokemonId::SCYTHER
        ],
        PokemonFamilyId::FAMILY_JYNX => [
            PokemonId::JYNX
        ],
        PokemonFamilyId::FAMILY_ELECTABUZZ => [
            PokemonId::ELECTABUZZ
        ],
        PokemonFamilyId::FAMILY_MAGMAR => [
            PokemonId::MAGMAR
        ],
        PokemonFamilyId::FAMILY_PINSIR => [
            PokemonId::PINSIR
        ],
        PokemonFamilyId::FAMILY_TAUROS => [
            PokemonId::TAUROS
        ],
        PokemonFamilyId::FAMILY_MAGIKARP => [
            PokemonId::MAGIKARP,
            PokemonId::GYARADOS
        ],
        PokemonFamilyId::FAMILY_LAPRAS => [
            PokemonId::LAPRAS
        ],
        PokemonFamilyId::FAMILY_DITTO => [
            PokemonId::DITTO
        ],
        PokemonFamilyId::FAMILY_EEVEE => [
            PokemonId::EEVEE,
            PokemonId::JOLTEON,
            PokemonId::VAPOREON,
            PokemonId::FLAREON
        ],
        PokemonFamilyId::FAMILY_PORYGON => [
            PokemonId::PORYGON
        ],
        PokemonFamilyId::FAMILY_OMANYTE => [
            PokemonId::OMANYTE,
            PokemonId::OMASTAR
        ],
        PokemonFamilyId::FAMILY_KABUTO => [
            PokemonId::KABUTO,
            PokemonId::KABUTOPS
        ],
        PokemonFamilyId::FAMILY_AERODACTYL => [
            PokemonId::AERODACTYL
        ],
        PokemonFamilyId::FAMILY_SNORLAX => [
            PokemonId::SNORLAX
        ],
        PokemonFamilyId::FAMILY_ARTICUNO => [
            PokemonId::ARTICUNO
        ],
        PokemonFamilyId::FAMILY_ZAPDOS => [
            PokemonId::ZAPDOS
        ],
        PokemonFamilyId::FAMILY_MOLTRES => [
            PokemonId::MOLTRES
        ],
        PokemonFamilyId::FAMILY_DRATINI => [
            PokemonId::DRATINI,
            PokemonId::DRAGONAIR,
            PokemonId::DRAGONITE
        ],
        PokemonFamilyId::FAMILY_MEWTWO => [
            PokemonId::MEWTWO
        ],
        PokemonFamilyId::FAMILY_MEW => [
            PokemonId::MEW
        ]
    ];

    private static $highestForFamily = [
        PokemonFamilyId::FAMILY_BULBASAUR => [
            PokemonId::VENUSAUR
        ],
        PokemonFamilyId::FAMILY_CHARMANDER => [
            PokemonId::CHARIZARD
        ],
        PokemonFamilyId::FAMILY_SQUIRTLE => [
            PokemonId::BLASTOISE
        ],
        PokemonFamilyId::FAMILY_CATERPIE => [
            PokemonId::BUTTERFREE
        ],
        PokemonFamilyId::FAMILY_WEEDLE => [
            PokemonId::BEEDRILL
        ],
        PokemonFamilyId::FAMILY_PIDGEY => [
            PokemonId::PIDGEOT
        ],
        PokemonFamilyId::FAMILY_RATTATA => [
            PokemonId::RATICATE
        ],
        PokemonFamilyId::FAMILY_SPEAROW => [
            PokemonId::FEAROW
        ],
        PokemonFamilyId::FAMILY_EKANS => [
            PokemonId::ARBOK
        ],
        PokemonFamilyId::FAMILY_PIKACHU => [
            PokemonId::RAICHU
        ],
        PokemonFamilyId::FAMILY_SANDSHREW => [
            PokemonId::SANDSLASH
        ],
        PokemonFamilyId::FAMILY_NIDORAN_FEMALE => [
            PokemonId::NIDOQUEEN
        ],
        PokemonFamilyId::FAMILY_NIDORAN_MALE => [
            PokemonId::NIDOKING
        ],
        PokemonFamilyId::FAMILY_CLEFAIRY => [
            PokemonId::CLEFABLE
        ],
        PokemonFamilyId::FAMILY_VULPIX => [
            PokemonId::NINETALES
        ],
        PokemonFamilyId::FAMILY_JIGGLYPUFF => [
            PokemonId::WIGGLYTUFF
        ],
        PokemonFamilyId::FAMILY_ZUBAT => [
            PokemonId::GOLBAT
        ],
        PokemonFamilyId::FAMILY_ODDISH => [
            PokemonId::VILEPLUME
        ],
        PokemonFamilyId::FAMILY_PARAS => [
            PokemonId::PARASECT
        ],
        PokemonFamilyId::FAMILY_VENONAT => [
            PokemonId::VENOMOTH
        ],
        PokemonFamilyId::FAMILY_DIGLETT => [
            PokemonId::DUGTRIO
        ],
        PokemonFamilyId::FAMILY_MEOWTH => [
            PokemonId::PERSIAN
        ],
        PokemonFamilyId::FAMILY_PSYDUCK => [
            PokemonId::GOLDUCK
        ],
        PokemonFamilyId::FAMILY_MANKEY => [
            PokemonId::PRIMEAPE
        ],
        PokemonFamilyId::FAMILY_GROWLITHE => [
            PokemonId::ARCANINE
        ],
        PokemonFamilyId::FAMILY_POLIWAG => [
            PokemonId::POLIWRATH
        ],
        PokemonFamilyId::FAMILY_ABRA => [
            PokemonId::ALAKAZAM
        ],
        PokemonFamilyId::FAMILY_MACHOP => [
            PokemonId::MACHAMP
        ],
        PokemonFamilyId::FAMILY_BELLSPROUT => [
            PokemonId::VICTREEBEL
        ],
        PokemonFamilyId::FAMILY_TENTACOOL => [
            PokemonId::TENTACRUEL
        ],
        PokemonFamilyId::FAMILY_GEODUDE => [
            PokemonId::GOLEM
        ],
        PokemonFamilyId::FAMILY_PONYTA => [
            PokemonId::RAPIDASH
        ],
        PokemonFamilyId::FAMILY_SLOWPOKE => [
            PokemonId::SLOWBRO
        ],
        PokemonFamilyId::FAMILY_MAGNEMITE => [
            PokemonId::MAGNETON
        ],
        PokemonFamilyId::FAMILY_FARFETCHD => [
            PokemonId::FARFETCHD
        ],
        PokemonFamilyId::FAMILY_DODUO => [
            PokemonId::DODRIO
        ],
        PokemonFamilyId::FAMILY_SEEL => [
            PokemonId::DEWGONG
        ],
        PokemonFamilyId::FAMILY_GRIMER => [
            PokemonId::MUK
        ],
        PokemonFamilyId::FAMILY_SHELLDER => [
            PokemonId::CLOYSTER
        ],
        PokemonFamilyId::FAMILY_GASTLY => [
            PokemonId::GENGAR
        ],
        PokemonFamilyId::FAMILY_ONIX => [
            PokemonId::ONIX
        ],
        PokemonFamilyId::FAMILY_DROWZEE => [
            PokemonId::DROWZEE
        ],
        PokemonFamilyId::FAMILY_KRABBY => [
            PokemonId::KINGLER
        ],
        PokemonFamilyId::FAMILY_VOLTORB => [
            PokemonId::ELECTRODE
        ],
        PokemonFamilyId::FAMILY_EXEGGCUTE => [
            PokemonId::EXEGGUTOR
        ],
        PokemonFamilyId::FAMILY_CUBONE => [
            PokemonId::MAROWAK
        ],
        PokemonFamilyId::FAMILY_HITMONLEE => [
            PokemonId::HITMONLEE
        ],
        PokemonFamilyId::FAMILY_HITMONCHAN => [
            PokemonId::HITMONCHAN
        ],
        PokemonFamilyId::FAMILY_LICKITUNG => [
            PokemonId::LICKITUNG
        ],
        PokemonFamilyId::FAMILY_KOFFING => [
            PokemonId::WEEZING
        ],
        PokemonFamilyId::FAMILY_RHYHORN => [
            PokemonId::RHYDON
        ],
        PokemonFamilyId::FAMILY_CHANSEY => [
            PokemonId::CHANSEY
        ],
        PokemonFamilyId::FAMILY_TANGELA => [
            PokemonId::TANGELA
        ],
        PokemonFamilyId::FAMILY_KANGASKHAN => [
            PokemonId::KANGASKHAN
        ],
        PokemonFamilyId::FAMILY_HORSEA => [
            PokemonId::SEADRA
        ],
        PokemonFamilyId::FAMILY_GOLDEEN => [
            PokemonId::SEAKING
        ],
        PokemonFamilyId::FAMILY_STARYU => [
            PokemonId::STARMIE
        ],
        PokemonFamilyId::FAMILY_MR_MIME => [
            PokemonId::MR_MIME
        ],
        PokemonFamilyId::FAMILY_SCYTHER => [
            PokemonId::SCYTHER
        ],
        PokemonFamilyId::FAMILY_JYNX => [
            PokemonId::JYNX
        ],
        PokemonFamilyId::FAMILY_ELECTABUZZ => [
            PokemonId::ELECTABUZZ
        ],
        PokemonFamilyId::FAMILY_MAGMAR => [
            PokemonId::MAGMAR
        ],
        PokemonFamilyId::FAMILY_PINSIR => [
            PokemonId::PINSIR
        ],
        PokemonFamilyId::FAMILY_TAUROS => [
            PokemonId::TAUROS
        ],
        PokemonFamilyId::FAMILY_MAGIKARP => [
            PokemonId::GYARADOS
        ],
        PokemonFamilyId::FAMILY_LAPRAS => [
            PokemonId::LAPRAS
        ],
        PokemonFamilyId::FAMILY_DITTO => [
            PokemonId::DITTO
        ],
        PokemonFamilyId::FAMILY_EEVEE => [
            PokemonId::EEVEE
        ],
        PokemonFamilyId::FAMILY_PORYGON => [
            PokemonId::PORYGON
        ],
        PokemonFamilyId::FAMILY_OMANYTE => [
            PokemonId::OMASTAR
        ],
        PokemonFamilyId::FAMILY_KABUTO => [
            PokemonId::KABUTOPS
        ],
        PokemonFamilyId::FAMILY_AERODACTYL => [
            PokemonId::AERODACTYL
        ],
        PokemonFamilyId::FAMILY_SNORLAX => [
            PokemonId::SNORLAX
        ],
        PokemonFamilyId::FAMILY_ARTICUNO => [
            PokemonId::ARTICUNO
        ],
        PokemonFamilyId::FAMILY_ZAPDOS => [
            PokemonId::ZAPDOS
        ],
        PokemonFamilyId::FAMILY_MOLTRES => [
            PokemonId::MOLTRES
        ],
        PokemonFamilyId::FAMILY_DRATINI => [
            PokemonId::DRAGONITE
        ],
        PokemonFamilyId::FAMILY_MEWTWO => [
            PokemonId::MEWTWO
        ],
        PokemonFamilyId::FAMILY_MEW => [
            PokemonId::MEW
        ]
    ];

    private static $meta = [];

    /**
     * Function for add all pokemon meta into the $meta array
     */
    static function populateMeta()
    {
        self::$meta = [
            PokemonId::BULBASAUR =>
                [new PokemonMeta(90, 0.16, 25, 0.1, 0.7, null)],

            PokemonId::IVYSAUR =>
                [new PokemonMeta(120, 0.08, 100, 0.07, 1, PokemonId::BULBASAUR)],

            PokemonId::VENUSAUR =>
                [new PokemonMeta(160, 0.04, 0, 0.05, 2, PokemonId::IVYSAUR)],

            PokemonId::CHARMANDER =>
                [new PokemonMeta(78, 0.16, 25, 0.1, 0.6, null)],

            PokemonId::CHARMELEON =>
                [new PokemonMeta(116, 0.08, 100, 0.07, 1.1, PokemonId::CHARMANDER)],

            PokemonId::CHARIZARD =>
                [new PokemonMeta(156, 0.04, 0, 0.05, 1.7, PokemonId::CHARMELEON)],

            PokemonId::SQUIRTLE =>
                [new PokemonMeta(88, 0.16, 25, 0.1, 0.5, null)],

            PokemonId::WARTORTLE =>
                [new PokemonMeta(118, 0.08, 100, 0.07, 1, PokemonId::SQUIRTLE)],

            PokemonId::BLASTOISE =>
                [new PokemonMeta(158, 0.04, 0, 0.05, 1.6, PokemonId::WARTORTLE)],

            PokemonId::CATERPIE =>
                [new PokemonMeta(90, 0.4, 12, 0.2, 0.3, null)],

            PokemonId::METAPOD =>
                [new PokemonMeta(100, 0.2, 50, 0.09, 0.7, PokemonId::CATERPIE)],

            PokemonId::BUTTERFREE =>
                [new PokemonMeta(120, 0.1, 0, 0.06, 1.1, PokemonId::METAPOD)],

            PokemonId::WEEDLE =>
                [new PokemonMeta(80, 0.4, 12, 0.2, 0.3, null)],

            PokemonId::KAKUNA =>
                [new PokemonMeta(90, 0.2, 50, 0.09, 0.6, PokemonId::WEEDLE)],

            PokemonId::BEEDRILL =>
                [new PokemonMeta(130, 0.1, 0, 0.06, 1, PokemonId::KAKUNA)],

            PokemonId::PIDGEY =>
                [new PokemonMeta(80, 0.4, 12, 0.2, 0.3, null)],

            PokemonId::PIDGEOTTO =>
                [new PokemonMeta(126, 0.2, 50, 0.09, 1.1, PokemonId::PIDGEY)],

            PokemonId::PIDGEOT =>
                [new PokemonMeta(166, 0.1, 0, 0.06, 1.5, PokemonId::PIDGEOTTO)],

            PokemonId::RATTATA =>
                [new PokemonMeta(60, 0.4, 25, 0.2, 0.3, null)],

            PokemonId::RATICATE =>
                [new PokemonMeta(110, 0.16, 0, 0.07, 0.7, PokemonId::RATTATA)],

            PokemonId::SPEAROW =>
                [new PokemonMeta(80, 0.4, 50, 0.15, 0.3, null)],

            PokemonId::FEAROW =>
                [new PokemonMeta(130, 0.16, 0, 0.07, 1.2, PokemonId::SPEAROW)],

            PokemonId::EKANS =>
                [new PokemonMeta(70, 0.4, 50, 0.15, 2, null)],

            PokemonId::ARBOK =>
                [new PokemonMeta(120, 0.16, 0, 0.07, 3.5, PokemonId::EKANS)],

            PokemonId::PIKACHU =>
                [new PokemonMeta(70, 0.16, 50, 0.1, 0.4, null)],

            PokemonId::SANDSHREW =>
                [new PokemonMeta(100, 0.4, 50, 0.1, 0.6, null)],

            PokemonId::SANDSLASH =>
                [new PokemonMeta(150, 0.16, 0, 0.06, 1, PokemonId::SANDSHREW)],

            PokemonId::NIDORAN_FEMALE =>
                [new PokemonMeta(110, 0.4, 25, 0.15, 0.4, null)],

            PokemonId::NIDORINA =>
                [new PokemonMeta(140, 0.2, 100, 0.07, 0.8, PokemonId::NIDORAN_FEMALE)],

            PokemonId::NIDOQUEEN =>
                [new PokemonMeta(180, 0.1, 0, 0.05, 1.3, PokemonId::NIDORINA)],

            PokemonId::NIDORAN_MALE =>
                [new PokemonMeta(92, 0.4, 25, 0.15, 0.5, null)],

            PokemonId::NIDORINO =>
                [new PokemonMeta(122, 0.2, 100, 0.07, 0.9, PokemonId::NIDORAN_MALE)],

            PokemonId::NIDOKING =>
                [new PokemonMeta(162, 0.1, 0, 0.05, 1.4, PokemonId::NIDORINO)],

            PokemonId::CLEFAIRY =>
                [new PokemonMeta(140, 0.24, 50, 0.1, 0.6, null)],

            PokemonId::CLEFABLE =>
                [new PokemonMeta(190, 0.08, 0, 0.06, 1.3, PokemonId::CLEFAIRY)],

            PokemonId::VULPIX =>
                [new PokemonMeta(76, 0.24, 50, 0.1, 0.6, null)],

            PokemonId::NINETALES =>
                [new PokemonMeta(146, 0.08, 0, 0.06, 1.1, PokemonId::VULPIX)],

            PokemonId::JIGGLYPUFF =>
                [new PokemonMeta(230, 0.4, 50, 0.1, 0.5, null)],

            PokemonId::WIGGLYTUFF =>
                [new PokemonMeta(280, 0.16, 0, 0.06, 1, PokemonId::JIGGLYPUFF)],

            PokemonId::ZUBAT =>
                [new PokemonMeta(80, 0.4, 50, 0.2, 0.8, null)],

            PokemonId::GOLBAT =>
                [new PokemonMeta(150, 0.16, 0, 0.07, 1.6, PokemonId::ZUBAT)],

            PokemonId::GLOOM =>
                [new PokemonMeta(120, 0.24, 100, 0.07, 0.8, PokemonId::ODDISH)],

            PokemonId::VILEPLUME =>
                [new PokemonMeta(150, 0.12, 0, 0.05, 1.2, PokemonId::GLOOM)],

            PokemonId::PARAS =>
                [new PokemonMeta(70, 0.32, 50, 0.15, 0.3, null)],

            PokemonId::PARASECT =>
                [new PokemonMeta(120, 0.16, 0, 0.07, 1, PokemonId::PARAS)],

            PokemonId::VENONAT =>
                [new PokemonMeta(120, 0.4, 50, 0.15, 1, null)],

            PokemonId::VENOMOTH =>
                [new PokemonMeta(140, 0.16, 0, 0.07, 1.5, PokemonId::VENONAT)],

            PokemonId::DIGLETT =>
                [new PokemonMeta(20, 0.4, 50, 0.1, 0.2, null)],

            PokemonId::DUGTRIO =>
                [new PokemonMeta(70, 0.16, 0, 0.06, 0.7, PokemonId::DIGLETT)],

            PokemonId::MEOWTH =>
                [new PokemonMeta(80, 0.4, 50, 0.15, 0.4, null)],

            PokemonId::PERSIAN =>
                [new PokemonMeta(130, 0.16, 0, 0.07, 1, PokemonId::MEOWTH)],

            PokemonId::PSYDUCK =>
                [new PokemonMeta(100, 0.4, 50, 0.1, 0.8, null)],

            PokemonId::GOLDUCK =>
                [new PokemonMeta(160, 0.16, 0, 0.06, 1.7, PokemonId::PSYDUCK)],

            PokemonId::PRIMEAPE =>
                [new PokemonMeta(130, 0.16, 0, 0.06, 1, null)],

            PokemonId::GROWLITHE =>
                [new PokemonMeta(110, 0.24, 50, 0.1, 0.7, null)],

            PokemonId::ARCANINE =>
                [new PokemonMeta(180, 0.08, 0, 0.06, 1.9, PokemonId::GROWLITHE)],

            PokemonId::POLIWAG =>
                [new PokemonMeta(80, 0.4, 25, 0.15, 0.6, null)],

            PokemonId::POLIWHIRL =>
                [new PokemonMeta(130, 0.2, 100, 0.07, 1, PokemonId::POLIWAG)],

            PokemonId::POLIWRATH =>
                [new PokemonMeta(180, 0.1, 0, 0.05, 1.3, PokemonId::POLIWHIRL)],

            PokemonId::ABRA =>
                [new PokemonMeta(50, 0.4, 25, 0.99, 0.9, null)],

            PokemonId::KADABRA =>
                [new PokemonMeta(80, 0.2, 100, 0.07, 1.3, PokemonId::ABRA)],

            PokemonId::ALAKAZAM =>
                [new PokemonMeta(110, 0.1, 0, 0.05, 1.5, PokemonId::KADABRA)],

            PokemonId::MACHAMP =>
                [new PokemonMeta(180, 0.1, 0, 0.05, 1.6, PokemonId::MACHOKE)],

            PokemonId::BELLSPROUT =>
                [new PokemonMeta(100, 0.4, 25, 0.15, 0.7, null)],

            PokemonId::WEEPINBELL =>
                [new PokemonMeta(130, 0.2, 100, 0.07, 1, PokemonId::BELLSPROUT)],

            PokemonId::VICTREEBEL =>
                [new PokemonMeta(160, 0.1, 0, 0.05, 1.7, PokemonId::WEEPINBELL)],

            PokemonId::TENTACOOL =>
                [new PokemonMeta(80, 0.4, 50, 0.15, 0.9, null)],

            PokemonId::TENTACRUEL =>
                [new PokemonMeta(160, 0.16, 0, 0.07, 1.6, PokemonId::TENTACOOL)],

            PokemonId::GEODUDE =>
                [new PokemonMeta(80, 0.4, 25, 0.1, 0.4, null)],

            PokemonId::GRAVELER =>
                [new PokemonMeta(110, 0.2, 100, 0.07, 1, PokemonId::GEODUDE)],

            PokemonId::GOLEM =>
                [new PokemonMeta(160, 0.1, 0, 0.05, 1.4, PokemonId::GRAVELER)],

            PokemonId::PONYTA =>
                [new PokemonMeta(100, 0.32, 50, 0.1, 1, null)],

            PokemonId::RAPIDASH =>
                [new PokemonMeta(130, 0.12, 0, 0.06, 1.7, PokemonId::PONYTA)],

            PokemonId::SLOWPOKE =>
                [new PokemonMeta(180, 0.4, 50, 0.1, 1.2, null)],

            PokemonId::SLOWBRO =>
                [new PokemonMeta(190, 0.16, 0, 0.06, 1.6, PokemonId::SLOWPOKE)],

            PokemonId::MAGNEMITE =>
                [new PokemonMeta(50, 0.4, 50, 0.1, 0.3, null)],

            PokemonId::MAGNETON =>
                [new PokemonMeta(100, 0.16, 0, 0.06, 1, PokemonId::MAGNEMITE)],

            PokemonId::FARFETCHD =>
                [new PokemonMeta(104, 0.24, 0, 0.09, 0.8, null)],

            PokemonId::DODUO =>
                [new PokemonMeta(70, 0.4, 50, 0.1, 1.4, null)],

            PokemonId::DODRIO =>
                [new PokemonMeta(120, 0.16, 0, 0.06, 1.8, PokemonId::DODUO)],

            PokemonId::SEEL =>
                [new PokemonMeta(130, 0.4, 50, 0.09, 1.1, null)],

            PokemonId::DEWGONG =>
                [new PokemonMeta(180, 0.16, 0, 0.06, 1.7, PokemonId::SEEL)],

            PokemonId::GRIMER =>
                [new PokemonMeta(160, 0.4, 50, 0.1, 0.9, null)],

            PokemonId::MUK =>
                [new PokemonMeta(210, 0.16, 0, 0.06, 1.2, PokemonId::GRIMER)],

            PokemonId::SHELLDER =>
                [new PokemonMeta(60, 0.4, 50, 0.1, 0.3, null)],

            PokemonId::CLOYSTER =>
                [new PokemonMeta(100, 0.16, 0, 0.06, 1.5, PokemonId::SHELLDER)],

            PokemonId::GASTLY =>
                [new PokemonMeta(60, 0.32, 25, 0.1, 1.3, null)],

            PokemonId::HAUNTER =>
                [new PokemonMeta(90, 0.16, 100, 0.07, 1.6, PokemonId::GASTLY)],

            PokemonId::GENGAR =>
                [new PokemonMeta(120, 0.08, 0, 0.05, 1.5, PokemonId::HAUNTER)],

            PokemonId::ONIX =>
                [new PokemonMeta(70, 0.16, 0, 0.09, 8.8, null)],

            PokemonId::DROWZEE =>
                [new PokemonMeta(120, 0.4, 50, 0.1, 1, null)],

            PokemonId::HYPNO =>
                [new PokemonMeta(170, 0.16, 0, 0.06, 1.6, PokemonId::DROWZEE)],

            PokemonId::KRABBY =>
                [new PokemonMeta(60, 0.4, 50, 0.15, 0.4, null)],

            PokemonId::KINGLER =>
                [new PokemonMeta(110, 0.16, 0, 0.07, 1.3, PokemonId::KRABBY)],

            PokemonId::VOLTORB =>
                [new PokemonMeta(80, 0.4, 50, 0.1, 0.5, null)],

            PokemonId::ELECTRODE =>
                [new PokemonMeta(120, 0.16, 0, 0.06, 1.2, PokemonId::VOLTORB)],

            PokemonId::EXEGGCUTE =>
                [new PokemonMeta(120, 0.4, 50, 0.1, 0.4, null)],

            PokemonId::EXEGGUTOR =>
                [new PokemonMeta(190, 0.16, 0, 0.06, 2, PokemonId::EXEGGCUTE)],

            PokemonId::CUBONE =>
                [new PokemonMeta(100, 0.32, 50, 0.1, 0.4, null)],

            PokemonId::MAROWAK =>
                [new PokemonMeta(120, 0.12, 0, 0.06, 1, PokemonId::CUBONE)],

            PokemonId::HITMONLEE =>
                [new PokemonMeta(100, 0.16, 0, 0.09, 1.5, null)],

            PokemonId::LICKITUNG =>
                [new PokemonMeta(180, 0.16, 0, 0.09, 1.2, null)],

            PokemonId::KOFFING =>
                [new PokemonMeta(80, 0.4, 50, 0.1, 0.6, null)],

            PokemonId::WEEZING =>
                [new PokemonMeta(130, 0.16, 0, 0.06, 1.2, PokemonId::KOFFING)],

            PokemonId::RHYHORN =>
                [new PokemonMeta(160, 0.4, 50, 0.1, 1, null)],

            PokemonId::RHYDON =>
                [new PokemonMeta(210, 0.16, 0, 0.06, 1.9, PokemonId::RHYHORN)],

            PokemonId::CHANSEY =>
                [new PokemonMeta(500, 0.16, 0, 0.09, 1.1, null)],

            PokemonId::TANGELA =>
                [new PokemonMeta(130, 0.32, 0, 0.09, 1, null)],

            PokemonId::HORSEA =>
                [new PokemonMeta(60, 0.4, 50, 0.1, 0.4, null)],

            PokemonId::SEADRA =>
                [new PokemonMeta(110, 0.16, 0, 0.06, 1.2, PokemonId::HORSEA)],

            PokemonId::GOLDEEN =>
                [new PokemonMeta(90, 0.4, 50, 0.15, 0.6, null)],

            PokemonId::SEAKING =>
                [new PokemonMeta(160, 0.16, 0, 0.07, 1.3, PokemonId::GOLDEEN)],

            PokemonId::STARYU =>
                [new PokemonMeta(60, 0.4, 50, 0.15, 0.8, null)],

            PokemonId::STARMIE =>
                [new PokemonMeta(120, 0.16, 0, 0.06, 1.1, PokemonId::STARYU)],

            PokemonId::MR_MIME =>
                [new PokemonMeta(80, 0.24, 0, 0.09, 1.3, null)],

            PokemonId::SCYTHER =>
                [new PokemonMeta(140, 0.24, 0, 0.09, 1.5, null)],

            PokemonId::JYNX =>
                [new PokemonMeta(130, 0.24, 0, 0.09, 1.4, null)],

            PokemonId::ELECTABUZZ =>
                [new PokemonMeta(130, 0.24, 0, 0.09, 1.1, null)],

            PokemonId::MAGMAR =>
                [new PokemonMeta(130, 0.24, 0, 0.09, 1.3, null)],

            PokemonId::PINSIR =>
                [new PokemonMeta(130, 0.24, 0, 0.09, 1.5, null)],

            PokemonId::TAUROS =>
                [new PokemonMeta(150, 0.24, 0, 0.09, 1.4, null)],

            PokemonId::MAGIKARP =>
                [new PokemonMeta(40, 0.56, 400, 0.15, 0.9, null)],

            PokemonId::GYARADOS =>
                [new PokemonMeta(190, 0.08, 0, 0.07, 6.5, PokemonId::MAGIKARP)],

            PokemonId::LAPRAS =>
                [new PokemonMeta(260, 0.16, 0, 0.09, 2.5, null)],

            PokemonId::DITTO =>
                [new PokemonMeta(96, 0.16, 0, 0.1, 0.3, null)],

            PokemonId::EEVEE =>
                [new PokemonMeta(110, 0.32, 25, 0.1, 0.3, null)],

            PokemonId::VAPOREON =>
                [new PokemonMeta(260, 0.12, 0, 0.06, 1, PokemonId::EEVEE)],

            PokemonId::JOLTEON =>
                [new PokemonMeta(130, 0.12, 0, 0.06, 0.8, PokemonId::EEVEE)],

            PokemonId::FLAREON =>
                [new PokemonMeta(130, 0.12, 0, 0.06, 0.9, PokemonId::EEVEE)],

            PokemonId::PORYGON =>
                [new PokemonMeta(130, 0.32, 0, 0.09, 0.8, null)],

            PokemonId::OMANYTE =>
                [new PokemonMeta(70, 0.32, 50, 0.09, 0.4, null)],

            PokemonId::OMASTAR =>
                [new PokemonMeta(140, 0.12, 0, 0.05, 1, PokemonId::OMANYTE)],

            PokemonId::KABUTO =>
                [new PokemonMeta(60, 0.32, 50, 0.09, 0.5, null)],

            PokemonId::KABUTOPS =>
                [new PokemonMeta(120, 0.12, 0, 0.05, 1.3, PokemonId::KABUTO)],

            PokemonId::AERODACTYL =>
                [new PokemonMeta(160, 0.16, 0, 0.09, 1.8, null)],

            PokemonId::SNORLAX =>
                [new PokemonMeta(320, 0.16, 0, 0.09, 2.1, null)],

            PokemonId::ARTICUNO =>
                [new PokemonMeta(180, 0, 0, 0.1, 1.7, null)],

            PokemonId::ZAPDOS =>
                [new PokemonMeta(180, 0, 0, 0.1, 1.6, null)],

            PokemonId::MOLTRES =>
                [new PokemonMeta(180, 0, 0, 0.1, 2, null)],

            PokemonId::DRATINI =>
                [new PokemonMeta(82, 0.32, 25, 0.09, 1.8, null)],

            PokemonId::DRAGONAIR =>
                [new PokemonMeta(122, 0.08, 100, 0.06, 4, PokemonId::DRATINI)],

            PokemonId::DRAGONITE =>
                [new PokemonMeta(182, 0.04, 0, 0.05, 2.2, PokemonId::DRAGONAIR)],

            PokemonId::MEWTWO =>
                [new PokemonMeta(212, 0, 0, 0.1, 2, null)],

            PokemonId::MEW =>
                [new PokemonMeta(200, 0, 0, 0.1, 0.4, null)],
        ];
    }

    /**
     * Return a family by id
     *
     * @param $id
     * @return mixed
     */
    public static function getFamily($id)
    {
        return self::$familys[$id];
    }

    /**
     * Return a pokemon meta
     *
     * @param $id
     * @return mixed
     */
    public static function getMeta($id)
    {
        self::populateMeta();
        return self::$meta[$id];
    }

    /**
     * Get the highest pokemon for his family
     *
     * @param $family
     * @return mixed
     */
    public static function getHightestForFamily($family)
    {
        return self::$highestForFamily[$family];
    }
}