<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;

class ObjectI {

    public function __construct()
    {
        
    }

    /** 
     * 
     * [TODO] .|. Sanitize properly when echoing/printing __toString(V)String
     */
    public function __toString(): string {

        return $this->toString();
    }

    /** 
     * 
     * [TODO] .|. Sanitize properly when echoing/printing __toString(V)String
     */
    public function toString( bool $isSanitize = true ): string {

        $toStr = $this::class . "@" . dechex($this->hashCode());

        return $isSanitize 
            ? htmlentities( $toStr, ENT_QUOTES|ENT_SUBSTITUTE, "UTF-8" )
            : $toStr;
    }

    /** 
     * 
     * [TODO] .|. Sanitize properly when echoing/printing __toString(V)String
     */
    public function toHTMLString(): string {

        return htmlentities($this->__toString(), ENT_QUOTES|ENT_SUBSTITUTE, "UTF-8");
    }

    public function hashCode(): int {

        return crc32( \spl_object_hash($this) );
    }

    /**
     * 
     * @param ObjectI|object|array|int|float|null $obj
     */
    public function equals( mixed $obj ): bool {

        return $obj === $this;
    }
}