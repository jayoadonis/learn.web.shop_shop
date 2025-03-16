<?php
declare(strict_types=1);

namespace learn\web\shop_shop\utils;

use learn\web\shop_shop\models\dbs\DbConfig;

enum Config  {

    case DATABASE;
    case GENERAL_CONFIG;

    use ConfigTrait;

    private function getValue(): DbConfig|string|false {

        return match( $this ) {
            self::DATABASE => new DbConfig(
                $_ENV["GYM_STONE_DB_PROVIDER"]?? $_SERVER["GYM_STONE_DB_PROVIDER"]?? getenv("GYM_STONE_DB_PROVIDER")?: "mysql"
            ),
            default => false
        };
    }

}