<?php
declare(strict_types=1);

namespace learn\web\shop_shop;

require_once __DIR__ . "/../../../../../../vendor/autoload.php";

require_once __DIR__ . "/utils/env/load_env.php";

use learn\web\shop_shop\utils\BaseDir;


// define( "__ROOT_DIR", realpath(__DIR__ . "/../../../../../../") );

// const __ROOT_DIR = __DIR__ . "/../../../../../..";

BaseDir::getInstance( 
    rootPath: __DIR__ . "/../../../../../..",
    blackListedFilePaths: ["src/", "logs/", ".env"]
);
