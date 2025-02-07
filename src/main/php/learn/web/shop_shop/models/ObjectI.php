<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;

class ObjectI {


    public function __toString(): string {

        return $this::class . "@" . $this->hashCode();
    }

    public function hashCode(): int {

        return hexdec( \spl_object_hash($this) );
    }

    /**
     * @param null|object|array|int|float $obj
     */
    public function equals( mixed $obj ): bool {

        return $obj === $this;
    }
}