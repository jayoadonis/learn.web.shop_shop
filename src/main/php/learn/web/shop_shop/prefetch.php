<?php
declare(strict_types=1);

namespace learn\web\shop_shop;

require_once __DIR__ . "/../../../../../../vendor/autoload.php";

require_once __DIR__ . "/utils/env/load_env.php";

use Exception;
use learn\web\shop_shop\utils\BaseDir;
use learn\web\shop_shop\utils\Log;
use learn\web\shop_shop\utils\LogType;

use function learn\web\shop_shop\utils\env\load_env;

// define( "__ROOT_DIR", realpath(__DIR__ . "/../../../../../../") );

// const __ROOT_DIR = __DIR__ . "/../../../../../..";


try {

    BaseDir::getInstance( 
        rootPath: __DIR__ . "/../../../../../..",
        blackListedFilePaths: ["src/", "logs/", ".env"]
    );
    
    load_env(
        BaseDir::getRootPath() . BaseDir::getResource("/.env.dev"),
        "GYM_STONE_"
    );

    $configFilePath = realpath(BaseDir::getRootPath() . BaseDir::getResource("/config.php"));

    if( !$configFilePath ) throw new \Exception("Config.php not found.");

    $_configs = require_once $configFilePath;
    
    define( "__CONFIGS", $_configs );

    Log::$isActive = __CONFIGS["general"]["is_active_log"];

}
catch( Exception $e ) {

    Log::log( LogType::ERR, "{$e->getMessage()}" );
    exit();
    // error_log("WARNING: environemnt variables or/and files not found.\n", 3, (BaseDir::getRootPath() . "/logs/error_log.log") );
}
