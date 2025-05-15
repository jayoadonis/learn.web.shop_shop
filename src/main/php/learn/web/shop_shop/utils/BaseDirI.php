<?php
declare(strict_types=1);


namespace learn\web\shop_shop\utils;

use learn\web\shop_shop\models\ObjectI;

final class BaseDirI extends ObjectI {

    // private static ?BaseDirI $baseDirI = null;

    private static ?string $rootDir = null;
    /**
     * @var array<string> 
     */
    private static array $whitelist = [];
    /**
     * @var array<string>
     */
    private static array $blacklist = [];

    private function __construct()
    {

    }

    // private function __construct( 
    //     string $rootDir
    // ) {
    //     $this->rootDir = $rootDir;
    //     $this->whitelist = [];
    //     $this->blacklist = [];
    // }

    public static function init( string $rootDir ): void {

        // if( self::$baseDirI !== null ) {

        //     self::$baseDirI = new BaseDirI( $rootDir );
        //     return;
        // }

        // Log::log( LogType::WARN, "BaseDirI object already initialized.");


        if( self::$rootDir === null ) {
            
            $rootDirInQuestion = realpath( $rootDir );

            if( $rootDirInQuestion === false ) {
                
                throw new \Exception("Invalid root directory: '{$rootDir}'");
            }

            self::$rootDir = $rootDirInQuestion;
            return;
        }

        Log::log( LogType::WARN, "BaseDirI already initialized: '". self::class . "'");
    }

    public static function setWhitelist( array $filepaths ): void {

        if( self::$rootDir === null )
            throw new \Exception("Error: Root Directory does not exist");

        self::$whitelist = array_filter(
            array_map(
                function($path){

                    $realpath = realpath(self::$rootDir . DIRECTORY_SEPARATOR . $path );

                    if( $realpath === false ) {

                        // throw new \Exception("Warning: Invalid whitelist path: '{$path}'");
                        // trigger_error("Warning: Invalid whitelist path: {$path}", E_USER_WARNING);
                        Log::log( LogType::WARN, "Warning: Invalid whitelist path: `{$path}`");
                        return false;
                    }

                    return $realpath;
                }, 
                $filepaths
            )
        );
    }

    public static function setBlacklist( array $filepaths ): void {

        if( self::$rootDir === null )
            throw new \Exception("Error: Root Directory does not exist");

        self::$blacklist = array_filter(
            array_map(
                function($path){
                    $realpath = realpath(self::$rootDir . DIRECTORY_SEPARATOR . $path );

                    if( $realpath === false ) {

                        Log::log( LogType::WARN, "Warning: Invalid blacklisted path: '{$path}");
                        return false;
                    }

                    return $realpath;
                }, 
                $filepaths 
            )
        );
    }

    public static function resolve(string $path): string {
        
        if( self::$rootDir === null )
            throw new \Exception("Error: Root Directory does not exist");

        $fullpath = realpath(self::$rootDir . DIRECTORY_SEPARATOR . $path);

        if( $fullpath === false )
            throw new \Exception("Relative Path does not exist: '{$path}'");
        
        if( strpos( $fullpath, self::$rootDir ) !== 0 )
            throw new \Exception("Access denied invalid relative path: '{$path}'");

        // if( self::isWhitelisted($fullpath) ) 
        //     throw new \Exception("Access denied {not whitelisted}: '{$path}'");

        if( self::isBlacklisted($fullpath) )
            throw new \Exception("Access denied {blacklisted}: '{$path}'");
        

        return substr( $fullpath, strpos($fullpath, preg_replace("/[\/\\\\]+/", DIRECTORY_SEPARATOR, $path) )?:0, strlen($fullpath) );
    }

    private static function isWhitelisted( string $absolutePath ): bool {

        if( empty(self::$whitelist) )
            return true;

        foreach( self::$whitelist as $allowedPath ) {

            if( strpos($absolutePath, $allowedPath) === 0 ) {

                if( !empty( $intersects = self::getGrayList() ) ) {
                    Log::log( 
                        LogType::WARN, "Warning: Blacklisted paths also found at Whitelisted paths: ["
                        . implode(", ", $intersects) . "]"
                    );
                }

                return true;
                
                // $allowedPathLen = strlen($allowedPath);

                // if (strlen($absolutePath) === $allowedPathLen || $absolutePath[$allowedPathLen] === DIRECTORY_SEPARATOR) {
                //     return true;
                // }
            }
        }

        return false;
    }

    private static function isBlacklisted( string $absolutePath ): bool {

        if( empty(self::$blacklist) )
            return false;

        for( $i = 0; $i < count(self::$blacklist); ++$i ) {

            if( strpos( $absolutePath, self::$blacklist[$i]) === 0 ) {

                if( !empty( $intersects = self::getGrayList() ) ) {
                    Log::log( 
                        LogType::WARN, "Warning: Blacklisted paths also found at Whitelisted paths: ["
                        . implode(", ", $intersects) . "]"
                    );
                    
                    return false;
                }

                if( !empty(self::$whitelist) && self::isWhitelisted($absolutePath) ) return false;

                return true;
            }
        }

        return false;
    }

    /**
     * 
     * @return array<string>
     */
    private static function getGrayList(): array {

        $intersects = array_intersect(
            self::$whitelist,
            self::$blacklist
        );

        // if( !empty( $intersects = array_intersect(self::$blacklist, self::$whitelist) ) ) {

        //     Log::log( 
        //         LogType::WARN, "Warning: Blacklisted paths also found at Whitelisted paths: ["
        //         . implode(", ", $intersects) . "]"
        //     );
        // }

        return $intersects;
    }

    public static function getRootDir(): string {

        if( self::$rootDir === null )
            throw new \Exception("Error: Root Directory not exists.");

        return self::$rootDir;
    }
}