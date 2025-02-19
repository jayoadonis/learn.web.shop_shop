<?php
declare(strict_types=1);

namespace learn\web\shop_shop\utils;

// use \BackedEnum;

// use const learn\web\shop_shop\__ROOT_DIR;


enum LogType: string /*implements BackedEnum*/ {
    case ERROR = "ERROR";
    case WARN = "WARN";
    case INFO = "INFO";
    case DEBUG = "DEBUG";

    public function code(): int {
        
        return match($this) {
            self::ERROR => 1,
            self::WARN => 2,
            self::INFO => 4,
            self::DEBUG => 8,
            default => 1
        };
    }
}

    
