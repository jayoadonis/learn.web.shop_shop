<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;


interface ISessionableI extends ISerializable {

    /**
     * 
     * @return class-string<ISessionableI>
     */
    public function getType(): mixed;
}