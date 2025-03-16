<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;

interface ISessionable {

    // /**
    //  * [TODO]
    //  * @return ObjectI|array<string,mixed>|string|null 
    //  */
    // public function getData(): ObjectI|array|string|null;

    /**
     * 
     * @return class-string<ISessionable> 
     */
    public function getType(): mixed;


    /**
     * - Runs before/with `serialize( ... )` function
     * 
     * @return array<string>
     */
    public function __sleep(): array;

    /**
     * 
     * - Run after `\unserialize( ... )` function
     * - Usually use for re-initialization or/and data integrity check (checksum)....
     * 
     * @return void
     */
    public function __wakeup(): void;
}