<?php
declare(strict_types=1);

namespace learn\web\shop_shop\utils;


function remove_trailing_whitespaces( ?string &$str ): void {

    if( $str === null || empty(trim($str)) ) {
        $str = '';
        return;
    }

    $lines = preg_split("/[\r\n]+/", $str);

    $str = '';

    foreach( $lines as $line ) {
        if( strlen($line) > 0 )
            $str .= ( $line . PHP_EOL );
    }

}