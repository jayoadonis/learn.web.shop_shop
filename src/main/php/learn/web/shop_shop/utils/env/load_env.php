<?php
declare(strict_types=1);

namespace learn\web\shop_shop\utils\env;

use \Exception;

function load_env( string $filePath ): void {

    if( !file_exists( $filePath ) )
        throw new Exception("Environment file not found: {$filePath}");

    $lines = \file( $filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );

    foreach( $lines as $line ) {

        if( empty($line = \trim($line)) || \strpos($line, '#') === 0 )
            continue;

        $parts = \explode('=', $line, 2);

        if( \count($parts) !== 2 )
            continue;

        $key    = \trim($parts[0]);
        $value  = \trim($parts[1]);
    
        if( (\strlen($value)>1) &&
            (
                ( $value[0] === '"' && \substr($value, -1) === '"') ||
                ( $value[0] === '\'' && \substr($value, -1) === '\'')
            )
        ) $value = \substr($value, 1, -1 );

        \putenv("{$key}={$value}");
        $_ENV[$key]     = $value;
        $_SERVER[$key]  = $value;
    }
}