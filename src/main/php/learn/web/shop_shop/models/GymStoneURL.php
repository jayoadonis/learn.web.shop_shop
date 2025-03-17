<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;

use learn\web\shop_shop\models\routes\Param;
use learn\web\shop_shop\models\routes\ParamPath;
use phpDocumentor\Reflection\Types\Self_;

// /**
//  * Marker interface for param path verbs.
//  * 
//  * @template T of IParamPathVerb
//  */
// interface IParamPathVerb {
//     /**
//      * Returns the "point" of the verb.
//      *
//      * @return T
//      */
//     public function point(): mixed;

// }

enum HomeParamPathVerb: string {
    case EDIT           = "edit";
    case CREATE         = "create";
    case DEMO_BUTTON    = "demo-button";
}

enum ProductParamPathVerb: string {
    case EDIT   = "edit";
    case CREATE = "create";
}



class GymStoneURLParamVerb extends ObjectI {

    public function __construct(
        public readonly ?string $edit = null,
        public readonly ?string $create = null,
        public readonly ?string $demoButton = null,
    ) {

    }
}


enum GymStoneURL : int {

    case HOME           = 1;
    case PRODUCT        = 2;
    case PROFILE        = 4;
    case SIGNING        = 8;
    case MUSIC_APP      = 16;

    case PAGE_NOT_FOUND = 64;

    public function get( ?string $paramPath = null ): string|null {

        if( $paramPath !== null && !empty($paramPath) && !preg_match("/(\/?{[a-z]+})+/", $paramPath) ) {
            //REM: [TODO] .|. throw exception...
            return null;
        }

        if( $paramPath !== null && !empty($paramPath) ) {

            $paramPath = trim($paramPath, " /");
            $paramPath = "/{$paramPath}";
        }
        else {
            $paramPath = '';
        }

        return match( $this ) {
            self::HOME => self::HOME->getRootPath() . $paramPath,
            self::PRODUCT => self::PRODUCT->getRootPath() . $paramPath,
            self::PROFILE => self::PROFILE->getRootPath() . $paramPath,
            default => self::PAGE_NOT_FOUND->getRootPath()
        };
    }

    public function getRootPath(): string {

        return match( $this ) {
            self::HOME          => "/home",
            self::PRODUCT       => "/product",
            self::PROFILE       => "/profile",
            self::SIGNING       => "/signing",
            self::MUSIC_APP     => "/music-app",
            default             => "/404"
        };
    }

    //REM: [TODO] .|. Make explicit object type...
    public function getParamVerbs(): object {

        return match( $this) {

            self::HOME          => (object)["demoButton" => "demo-button"],
            self::PRODUCT       => (object)["create" => "create", "edit" => "edit"],
            self::PROFILE       => (object)["edit" => "edit"],
            
        };
    }

    public static function validateParamPathVerbs( GymStoneURL $gymStoneURL, string|null &$inOutParamVerb ): void {

        if( $inOutParamVerb === null ) {
            return;
        }

        if (!in_array($inOutParamVerb, array_values((array)$gymStoneURL->getParamVerbs()), true)) {
            $inOutParamVerb = null;
        }
    }

    /**
     * 
     */
    public function getParamVerb(): GymStoneURLParamVerb|ProductParamPathVerb|HomeParamPathVerb {

        return match( $this ) {

            self::HOME          => HomeParamPathVerb::EDIT, //REM: [WOW] .|. Cyclical or Chaining??? But still a constant pointer 
            self::PRODUCT       => ProductParamPathVerb::EDIT, //REM: [WOW] .|. Cyclical or Chaining??? But still a constant pointer 
            self::PROFILE       => new GymStoneURLParamVerb(edit:"edit")
        };
    }


    public static function validateParamPathVerb( GymStoneURL $gymStoneURL, string|null &$inOutParamPathVerb ): void {

        if( $inOutParamPathVerb === null ) {
            return;
        }
        
        if ( !in_array($inOutParamPathVerb, array_values((array)$gymStoneURL->getParamVerb()), true)) {
            $inOutParamPathVerb = null;
        }
    }
}