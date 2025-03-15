<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;

enum Status : string {

    case UNKNOWN    = "N/a";
    case WAITING    = "WTG";
    case READY      = "RDY";
    case RUN        = "RUN";
    case TERMINATE  = "TNT";
    case PROTECTED  = "PTD";

    public function code(): int {

        return match( $this ) {
            self::UNKNOWN   => 1,
            self::WAITING   => 2,
            self::READY     => 4,
            self::RUN       => 8,
            self::TERMINATE => 16,
            self::PROTECTED => 32,
            default         => 1
        };
    }

}