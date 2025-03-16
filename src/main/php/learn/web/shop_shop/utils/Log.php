<?php

declare(strict_types=1);

namespace learn\web\shop_shop\utils;

use learn\web\shop_shop\models\ObjectI;

class Log extends ObjectI
{

    public static bool $isActive = true;
    /**
     * Logs an event.
     *
     * @param LogType      $log_type
     * @param string       $msg
     * @param null|string  $log_file_path  Optional log file name.
     * @param int          $lineCount      Line count threshold for log rotation.
     * @return void
     */
    public static function log(LogType $log_type, string $msg, ?string $log_file_path = null, int $lineCount = 2500): void
    {

        if (self::$isActive) {
            //REM: Set the timezone and timestamp.
            date_default_timezone_set("Asia/Manila");
            $timestamp = date("Y-m-d h:i:s A");

            //REM: Identify the requester. (In CLI mode, this will be 'CLI'.)
            $requester = $_SERVER['REMOTE_ADDR'] ?? 'CLI';

            //REM: Capture a backtrace for debugging purposes.
            ob_start();
            debug_print_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 3 /*\max(3, [COMPUTE])*/ );
            $trace = str_replace("\n", "\n\t", ob_get_clean());

            //REM: Build the log entry string.
            $log_entry = "[{$timestamp}] [{$log_type->code()}:{$log_type->value}] [Requester: {$requester}] '{$msg}'\n\t{$trace}\n";

            //REM: Use a default log file name if one isn't provided.
            $log_file_path ??= strtolower($log_type->value) . "-default.log";
            $log_file_path = BaseDir::getRootPath() . DIRECTORY_SEPARATOR . "logs" . DIRECTORY_SEPARATOR . $log_file_path;

            //REM: Ensure that the logs directory exists.
            $dir = dirname($log_file_path);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            //REM: Append the log entry to the log file atomically using LOCK_EX.
            file_put_contents($log_file_path, $log_entry, FILE_APPEND | LOCK_EX);

            //REM: Check if the log file exceeds the line count threshold and rotate if needed.
            if (file_exists($log_file_path)) {
                $lines = count(file($log_file_path));
                if ($lines >= $lineCount) {
                    $new_log_file_path = dirname($log_file_path) . DIRECTORY_SEPARATOR
                        . pathinfo($log_file_path, PATHINFO_FILENAME)
                        . '_' . date("Ymd_His") . '.'
                        . pathinfo($log_file_path, PATHINFO_EXTENSION);
                    rename($log_file_path, $new_log_file_path);
                }
            }

            //REM: If running in CLI mode, output the log entry to the console.
            if (php_sapi_name() === "cli") {
                echo $log_entry;
            }
        }
    }
}
