<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;

class ObjectI {


    public function __toString(): string {

        return $this::class . "@" . dechex($this->hashCode());
    }

    public function toHTMLString(): string {

        return htmlentities($this->__toString(), ENT_QUOTES|ENT_SUBSTITUTE, "UTF-8");
    }

    public function hashCode(): int {

        return crc32( \spl_object_hash($this) );
    }

    /**
     * 
     * @param ObjectI|null|object|array|int|float $obj
     */
    public function equals( mixed $obj ): bool {

        return $obj === $this;
    }
}