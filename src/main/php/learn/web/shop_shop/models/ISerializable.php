<?php
declare(strict_types=1);


namespace learn\web\shop_shop\models;


/**
 * 
 * - Works behind the scene with functions namely; ( `serialize( mixed ): string` and 
 *   `unserialize( string, array=[]): mixed`) 
 * - Traditional Serialization such as with; `__sleep(): array` cannot work with 
 *   base-class private properties
 * - Alternative (`__serialize(): array` and `__unserialize( array $data ): void` )
 */
interface ISerializable {


    /**
     * 
     * - Run before `serialize( mixed ): string` function
     * - Usually for specifying who/what should be serialize
     */
    public function __serialize(): array;

    /**
     * 
     * - Run after `unserialize( string, array = [] ): mixed` function
     * - Can be use for re-initialization or/and data integrity check (Checksum)
     */
    public function __unserialize( array $data ): void;

    /**
     * 
     * - Run after `unserialize( string, array = [] ): mixed` function or/and `__unserialize( array ): void` member function
     * - Usually for re-initialization or/and data integrity check (Checksum)
     */
    public function __wakeup(): void;
}