<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;


enum Status : string  {

    case NONE       = "Nil";
    case UNKNOWN    = "N/a";
    case WAITING    = "WTG";
    case READY      = "RDY";
    case RUN        = "RUN";
    case TERMINATE  = "TNT";
    case PROTECTED  = "PTD";

    public function code(): int {

        return match( $this ) {
            self::NONE      => 0, //REM: [TODO] .|. Is this proper '0' value? Might be signed int -(2^31)
            self::UNKNOWN   => 1,
            self::WAITING   => 2,
            self::READY     => 4,
            self::RUN       => 8,
            self::TERMINATE => 16,
            self::PROTECTED => 32,
            default         => 1
        };
    }

    public function toString(): string {

        return sprintf(
            "%s@%08x[case='%s', code=%d]",
            $this::class,
            $this->hashCode(),
            $this->value,
            $this->code()
        );
    }

    public function hashCode(): int {

        return crc32( $this->value . $this->code() );
    }

}