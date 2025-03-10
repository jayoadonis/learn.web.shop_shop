<?php
declare(strict_types=1);


//REM: [TODO] .|. Remove color theme local storage in JS, try only use this implementation....

if( session_status() === PHP_SESSION_NONE ) {
    session_start();
}

//REM: Get the raw POST data.
$rawData = file_get_contents('php://input');
$data = json_decode($rawData);

if (json_last_error() !== JSON_ERROR_NONE) {
    //REM: Handle JSON parsing error
    error_log('JSON decode error: ' . json_last_error_msg());

    //REM: Optionally return a response or exit.
    echo json_encode([
        'responseCode'  => 500,
        'isSuccess'     => false,
        'message'       => 'JSON decode error: ' . json_last_error_msg()
    ]);
    exit();
}

header('Content-Type: application/json');

const COLOR_THEMES = ['light', 'dark'];


$clientTheme = strtolower($data?->theme??"");


//REM: Check if the required theme key exists in the decoded data.
if (!empty($clientTheme) && in_array($clientTheme, COLOR_THEMES, true)) {
    $_SESSION['theme'] = $clientTheme;
    echo json_encode([
        'theme'         => $_SESSION['theme'],
        'responseCode'  => 200,
        'isSuccess'     => true,
        'message'       => 'Current General Color Theme Retrieve'
    ]);
} else {
    //REM: http_response_code(400);
    echo json_encode([
        'responseCode'  => 400,
        'isSuccess'     => false,
        'message'       => 'Invalid theme key and/or value. Should have key: "theme" or/and a value either: [' . implode(", ", COLOR_THEMES) . "]"
    ]);
    exit();
}
