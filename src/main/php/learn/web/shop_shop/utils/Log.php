<?php

declare(strict_types=1);

namespace learn\web\shop_shop\utils;

use learn\web\shop_shop\models\ObjectI;

class Log extends ObjectI
{

    public static function log(LogType $log_type, string $msg, null|string $log_file_path = null): void
    {

        date_default_timezone_set("Asia/Manila");
        $timestamp = date("Y-m-d h:i:s A");
        
        ob_start();
        debug_print_backtrace();
        $trace = str_replace("\n", "\n\t", ob_get_clean());

        $log_entry = "[{$timestamp}] [{$log_type->code()}] [{$log_type->value}] {$msg}\n\t{$trace}\n";

        $log_file_path ??= strtolower($log_type->value) . "-default.log";

        $log_file_path = __ROOT_DIR . "/logs/" . $log_file_path;

        $dir = dirname($log_file_path);

        if (!is_dir($dir))
            mkdir($dir, 0755, true);

        file_put_contents($log_file_path, $log_entry, FILE_APPEND);

        if (php_sapi_name() === "cli")
            echo $log_entry;

        return;
    }
}
