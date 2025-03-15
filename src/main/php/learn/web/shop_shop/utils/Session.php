<?php

declare(strict_types=1);

namespace learn\web\shop_shop\utils;

use learn\web\shop_shop\models\ObjectI;
use learn\web\shop_shop\models\ISessionable;

/**
 * Session management class for handling ISessionable objects.
 */
class Session extends ObjectI
{

    /**
     * 
     * @var array<string|class-string<ISessionable>>
     */
    private static array $keys = [];

    /**
     * Stores a sessionable object into the session.
     *
     * @template T of ISessionable
     * @param T $sessionable The object to store in the session.
     * @return void
     */
    public static function set(mixed $sessionable): void
    {
        // if( session_status() === PHP_SESSION_NONE )
        //     session_start();
        // $_SESSION[$sessionable->getType()] = $sessionable;

        self::setWithExplicitId($sessionable->getType(), $sessionable);
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

        if (session_status() === PHP_SESSION_NONE)
            session_start();

        if (!in_array($id, self::$keys, true))
            $keys[] = $id;

        $_SESSION[$id] = base64_encode(serialize($data));
    }

    /**
     * Retrieves a sessionable object from the session.
     *
     * @template T of ISessionable | object | string | null
     * @param string|class-string<T> $id A canonical classname identifying the sessionable id.
     * @return T|null Returns the sessionable object if found, otherwise null.
     */
    public static function get(mixed $id): mixed
    {

        if (session_status() === PHP_SESSION_NONE)
            session_start();

        $data = $_SESSION[$id] ?? null;

        return $data ? unserialize(base64_decode($data)) : null;
    }

    /**
     * Clears all session data, removes the session cookie, and destroys the session.
     *
     * @return void
     */
    public static function clearAll(): void
    {
        //REM: Ensure the session is started.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        //REM: [TODO] If you have specific keys to clear, unset them. Otherwise, clearing the entire session array is sufficient.
        if (isset(self::$keys) && is_array(self::$keys)) {
            foreach (self::$keys as $key) {
                unset($_SESSION[$key]);
            }
        }
        //REM: Clear all session variables.
        $_SESSION = [];

        //REM: Remove the session cookie if sessions use cookies.
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            //REM: Set the cookie to expire in the past.
            setcookie(
                session_name(),
                '',
                time() - (11*60*60 + 59*60), //REM: 11hrs 59mins. `42000` Standard expiration value used to force the cookie removal.
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        //REM: Unset all session variables and destroy the session.
        session_unset();
        session_destroy();

        //REM: Optional: start a new session and regenerate the session id.
        //REM: Remove or comment out these lines if you don't need a new session immediately.
        session_start();
        session_regenerate_id(true);
    }
}
