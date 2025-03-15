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

BaseDir::getInstance( 
    rootPath: __DIR__ . "/../../../../../..",
    blackListedFilePaths: ["src/", "logs/", ".env"]
);


try {
    
    load_env(
        BaseDir::getRootPath() . BaseDir::getResource("/.env.dev")
    );

    Log::$isActive = filter_var( getenv("IS_ACTIVE_LOG"), FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE ) ?? true;

}
catch( Exception $e ) {

    Log::log( LogType::WARN, "Warning: environment variables or/and env files not found. {$e}" );
    // error_log("WARNING: environemnt variables or/and files not found.\n", 3, (BaseDir::getRootPath() . "/logs/error_log.log") );
}
