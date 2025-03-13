<?php
declare(strict_types=1);

require_once(__DIR__ . "/../../../src/main/php/learn/web/shop_shop/prefetch.php");


use learn\web\shop_shop\utils\Session;

if( session_status() === PHP_SESSION_NONE )
    session_start();

header("Content-Type: application/json");


$reqData    = file_get_contents("php://input");
$objData    = json_decode($reqData);

if( json_last_error() !== JSON_ERROR_NONE ) {
    error_log("Error: JSON decoding; " . json_last_error_msg(), E_ERROR);
    responseThemeJson(
        null,
        500,
        false,
        "Error: JSON decoding; " . json_last_error_msg()
    );
}

const COLOR_THEME = ["light", "dark"];
$clientTheme = strtolower($objData?->theme??'');

if( !empty( $clientTheme ) && in_array( $clientTheme, COLOR_THEME ) ) {

    Session::setWithExplicitId("theme", $clientTheme);

    responseThemeJson(
        $clientTheme,
        200,
        true,
        "Successfully sessionified..."
    );
}
else {

    responseThemeJson(
        null,
        400,
        false,
        strtr(
            "Invalid client request theme format: {reqData}\nBut the Server color theme contain: {colorTheme}",
            [ 
                "{reqData}"     => $reqData,
                "{colorTheme}"  => json_encode(COLOR_THEME)
            ]
        )
    );
}


function responseThemeJson(
    string|null $theme,
    int $resCode,
    bool $isSuccess,
    string $msg
): void {
    echo json_encode([
        "theme"         => $theme,
        "responseCode"  => $resCode,
        "isSuccess"     => $isSuccess,
        "message"       => $msg
    ], JSON_UNESCAPED_SLASHES | JSON_HEX_QUOT);
    exit();
}

