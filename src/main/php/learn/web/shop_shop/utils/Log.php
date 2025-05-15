<?php

declare(strict_types=1);

namespace learn\web\shop_shop\utils;

use learn\web\shop_shop\models\ObjectI;



/**
 * Custom error handler that outputs error messages to the browser's console.
 *
 * @param int    $errno   The error level.
 * @param string $errstr  The error message.
 * @param string $errfile The filename that the error was raised in.
 * @param int    $errline The line number the error was raised at.
 * @return bool  True if the error was handled.
 */
function errorHandlerI(int $errno, string $errstr, string $errfile, int $errline): bool {

    
    $console_type = match( $errno ) {

        E_USER_NOTICE => "info",
        E_USER_WARNING => "warn",
        E_USER_ERROR => "error",
        default => "error"
    };

    $errorMessage = sprintf(
        "PHP {$console_type} [%d]: %s in %s on line %d", 
        $errno, $errstr, $errfile, $errline
    );

    if( php_sapi_name() === "cli" ) {

        echo $errorMessage;
    }
    else
        echo "<script>console.{$console_type}(". json_encode($errorMessage) . ");</script>";

    return true;
}
                
set_error_handler( __NAMESPACE__ . '\errorHandlerI' );


class Log extends ObjectI
{

    public static bool $isActive = true;

    /**
     * 
     * @var array<string> $showLogTypes
     */
    public static array $showLogTypes = [];

    private static ?Log $instance = null;

    private function __construct()
    {
        self::$showLogTypes = array_map( function($logType) {

            return $logType->value;
            
        }, LogType::cases() );
    }

    public static function instantiate(): void {

        if( self::$instance === null ) self::$instance = new Log();

    }

    /**
     * Logs an event.
     *
     * @param LogType      $log_type
     * @param string       $msg
     * @param null|string  $log_file_path  Optional log file name.
     * @param int          $lineCount      Line count threshold for log rotation.
     * @return void
     */
    public static function log(LogType $log_type, string $msg, $showInConsole = true, ?string $log_file_path = null, int $lineCount = 2500): void
    {
        if( self::$instance === null )
            throw new \Exception("Log.php; Illegal State exception, instantiation not executed");

        if ( self::$isActive && ( (strpos( implode(", ", self::$showLogTypes), $log_type->value ) !== false ) ? true : false ) ) {

            //REM: Set the timezone and timestamp.
            date_default_timezone_set("Asia/Manila");
            $timestamp = date("Y-m-d h:i:s A");

            //REM: Identify the requester. (In CLI mode, this will be 'CLI'.)
            $requester = $_SERVER['REMOTE_ADDR'] ?? 'CLI';

            //REM: Capture a backtrace for debugging purposes.
            ob_start();
            debug_print_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS /*, 3*/ /*\max(3, [COMPUTE])*/ );
            $trace = str_replace("\n", "\n\t", ob_get_clean());

            //REM: Build the log entry string.
            $log_entry = "[{$timestamp}] [{$log_type->code()}:{$log_type->value}] [Requester: {$requester}] {{$msg}}\n\t{$trace}\n";

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

            if ( $showInConsole ) {
                // echo $log_entry;
                $trigger_error_type = match( $log_type ) {
                    LogType::DEBUG => E_USER_NOTICE,
                    LogType::INFO => E_USER_NOTICE,
                    LogType::WARN => E_USER_WARNING,
                    LogType::ERR => E_USER_ERROR,
                    default => E_USER_ERROR
                };

                trigger_error( 
                    $log_entry,
                    $trigger_error_type
                );
            }
        }
    }
}