<?php
declare(strict_types=1);

namespace learn\web\shop_shop;

use learn\web\shop_shop\utils\BaseDir;

require_once __DIR__ . "/../../../../../../vendor/autoload.php";

// define( "__ROOT_DIR", realpath(__DIR__ . "/../../../../../../") );

// const __ROOT_DIR = __DIR__ . "/../../../../../..";

BaseDir::getInstance( 
    __DIR__ . "/../../../../../..",
    ["src/", "logs/", ".env"]
);
