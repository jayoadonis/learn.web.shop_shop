<?php
declare(strict_types=1);

use learn\web\shop_shop\utils\LogType;

return [
    
    "general" => [
        "app_mode" => getenv("GYM_STONE_APP_MODE")?: "dev-default",
        "app_name" => getenv("GYM_STONE_APP_NAME")?: "title-default",
        "is_active_log" => filter_var( getenv("GYM_STONE_IS_ACTIVE_LOG"), FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE ) ?? true,
        "show_log_types" => !empty($log_types = unserialize( getenv("GYM_STONE_SHOW_LOG_TYPES") ?: "" )) && !empty($log_types[0])
            ? $log_types 
            : array_map( function($logType) { return $logType->value; }, LogType::cases() ),
    ],

    "database" => [
        "provider" => getenv("GYM_STONE_DB_PROVIDER")?: "mysql",
    ]
];