<?php
declare(strict_types=1);

namespace learn\web\shop_shop\utils;

use learn\web\shop_shop\models\Entity;
use learn\web\shop_shop\models\ObjectI;
use learn\web\shop_shop\models\ISessionable;
use learn\web\shop_shop\models\User;

class Session extends ObjectI {

    /**
     * @var array<class-string<ISessionable>,ISessionable> $GET
     */
    // protected static array $GET;


    /**
     * 
     * @template T of ISessionable
     * @param T $sessionable
     */
    public static function set(
        mixed $sessionable
     ): void {

        // self::$GET[$sessionable->getType()]
        //     = $sessionable;

        $_SESSION[$sessionable->getType()]
            = $sessionable;

     }

     /**
      * @template T of ISessionable
      * @param class-string<T> $type A cannonical classname
      * @return T|null
      */
     public static function get( string $type ): mixed {

        // return self::$GET[$type] ?? null;

        return $_SESSION[$type]?? null;
     }

    //  /**
    //   * @param class-string<ISessionable> $type
    //   */
    //  public static function update( string $type ): void {

    //     $identifier = null;

    //     if( ($sessionable = self::$GET[$type]) && is_object($identifier = $sessionable->getData()) ) {
    //         self::$GET[$type] = $identifier;
    //     } 
    //     elseif( $identifier && is_array($identifier) ) {
    //     }
    //  }
}
