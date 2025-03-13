<?php
declare(strict_types=1);

namespace learn\web\shop_shop\utils;

use learn\web\shop_shop\models\ObjectI;
use learn\web\shop_shop\models\ISessionable;

/**
 * Session management class for handling ISessionable objects.
 */
class Session extends ObjectI {

    /**
     * Stores a sessionable object into the session.
     *
     * @template T of ISessionable
     * @param T $sessionable The object to store in the session.
     * @return void
     */
    public static function set(mixed $sessionable): void {
        // if( session_status() === PHP_SESSION_NONE )
        //     session_start();
        // $_SESSION[$sessionable->getType()] = $sessionable;

        self::setWithExplicitId( $sessionable->getType(), $sessionable );
    }

    /**
     * 
     * @template V of ISessionable | object | string | null
     * @template K of string | class-string<V>
     * @param V $data
     * @param K $id
     */
    public static function setWithExplicitId( 
        mixed $id,
        mixed $data
    ): void {

        if( session_status() === PHP_SESSION_NONE )
            session_start();

        $_SESSION[$id] = $data;
    }

    /**
     * Retrieves a sessionable object from the session.
     *
     * @template T of ISessionable | object | string | null
     * @param string|class-string<T> $type A canonical classname identifying the sessionable type.
     * @return T|null Returns the sessionable object if found, otherwise null.
     */
    public static function get(mixed $type): mixed {
        
        if( session_status() === PHP_SESSION_NONE )
            session_start();

        return $_SESSION[$type] ?? null;
    }

    /**
     * Clears all session data, removes the session cookie, and destroys the session.
     *
     * @return void
     */
    public static function clearAll(): void {
        //REM: Ensure the session is started.
        if( session_status() === PHP_SESSION_NONE )
            session_start();

        //REM: Clear all session variables.
        $_SESSION = [];

        //REM: Remove the session cookie if sessions use cookies.
        if (ini_get("session.use_cookies")) {
            
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - (11*60*60 + 59*60), //REM: 11 hrs and 59 mins
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        //REM: Destroy the session.
        session_destroy();
    }
}
