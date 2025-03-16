<?php
declare(strict_types=1);


namespace learn\web\shop_shop\utils;

use learn\web\shop_shop\models\dbs\DbConfig;

trait ConfigTrait {

    public function data(): DbConfig|string|false {

        return $this->getValue();
    }

    protected abstract function getValue(): DbConfig|string|false;
}