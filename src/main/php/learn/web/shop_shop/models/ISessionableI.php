<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;


interface ISessionableI extends ISerializable {

    /**
     * 
     * @return class-string<ISessionable>
     */
    public function getType(): mixed;
}