<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;

interface ISessionable {

    /**
     * 
     * @return ObjectI|array<string,mixed>|string|null 
     */
    public function getData(): ObjectI|array|string|null;

    /**
     * 
     * @return class-string<ISessionable> 
     */
    public function getType(): mixed;
}