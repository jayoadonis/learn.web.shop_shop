<?php
declare(strict_types=1);

namespace learn\web\shop_shop\utils\env;

use \Exception;
use learn\web\shop_shop\utils\Log;
use learn\web\shop_shop\utils\LogType;

function load_env( string $filePath, ?string $prefixKey = null ): int|false {

    if( !file_exists( $filePath ) ) {

        throw new Exception("Environment file not found: {$filePath}");
        // return false;
    }

    $lines = \file( $filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );

    $prefixKey ??= "";

    foreach( $lines as $line ) {

        if( empty($line = \trim($line)) || \strpos($line, '#') === 0 )
            continue;

        $parts = \explode('=', $line, 2);

        if( \count($parts) !== 2 )
            continue;

        if( !empty($prefixKey) && \strpos($line, $prefixKey) !== 0 ) {

            $prevIsActive = Log::$isActive; //REM: [YIKES..., THREAD_NOT_SAFE]
            Log::$isActive = true;

            Log::log( LogType::WARN, "Warning: load env prefix \"{$prefixKey}\" did not found at key: \"{$parts[0]}\"");

            Log::$isActive = $prevIsActive; //REM: [YIKES..., THREAD_NOT_SAFE]
            continue;
        }

        $key    = \trim($parts[0]);
        $value  = \trim($parts[1]);

        if( empty($value) ) continue;
    
        if( (\strlen($value)>1) &&
            (
                ( $value[0] === '"' && \substr($value, -1) === '"') ||
                ( $value[0] === '\'' && \substr($value, -1) === '\'')
            )
        ) {


            // $value = preg_replace("/^[\"']|[\"']$/", '', $value);

            $value = \substr($value, 1, -1);
        }


        if( (\strlen($value) > 1) 
            && ( $value[0] === '[' && \substr($value, -1) === ']') 
        ) {

            $value = \substr($value, 1, -1);

            $values = \explode(",", $value);

            $value = \serialize($values);
        }

        if( empty( \trim($value) ) ) continue;

        // echo $key . ": " . $value . "<br>";

        \putenv("{$key}={$value}");
        $_ENV[$key]     = $value;
        $_SERVER[$key]  = $value;

    }

    return filesize($filePath);
}