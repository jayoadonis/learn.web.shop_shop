<?php
declare(strict_types=1);


return [
    
    "general" => [
        "app_mode" => getenv("GYM_STONE_APP_MODE")?: "dev-default",
        "app_name" => getenv("GYM_STONE_APP_NAME")?: "title-default",
        "is_active_log" => filter_var( getenv("GYM_STONE_IS_ACTIVE_LOG"), FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE ) ?? true,
    ],

    "database" => [
        "provider" => getenv("GYM_STONE_DB_PROVIDER")?: "mysql",
    ]
];