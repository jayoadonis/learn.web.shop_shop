<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;

use learn\web\shop_shop\utils\BaseDir;

class JSManagerI extends ClientSideCodeAsset {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    protected function echoIt(): void {
        ob_start();

        // if( session_status() === PHP_SESSION_NONE )
        //     session_start();

        // // Set and sanitize the current URL from the session and request URI
        // $currentURL = isset($_SESSION["current_url"]) ? $_SESSION["current_url"] : "";
        // $_SESSION["current_url"] = trim(parse_url($_SERVER["REQUEST_URI"] ?? "/404", PHP_URL_PATH), "/");

        // Only proceed if the current URL has changed
        // if ($currentURL !== $_SESSION["current_url"]) {
            $mainJSAsset = "public/resources/js/main.js";
            $mainFilePath = BaseDir::getRootPath() . DIRECTORY_SEPARATOR . $mainJSAsset;

            // Optionally output the main file path for debugging
            // print_r($mainFilePath);

            // Delete the main file if it exists
            if (file_exists($mainFilePath)) {
                unlink($mainFilePath);
            }

            // Open the main file for appending content
            $mainFileHandle = fopen($mainFilePath, "a");

            if ($mainFileHandle !== false) {
                fwrite($mainFileHandle, "window.document.addEventListener('DOMContentLoaded', function(){\n");

                foreach ($this->assets as $key => $assetPath) {
                    // Output the script tag
                    ?>
                    <script id="<?=$key?>" src="<?= DIRECTORY_SEPARATOR . $assetPath ?>"></script>
                    <?php

                    $assetFilePath = BaseDir::getRootPath() . DIRECTORY_SEPARATOR . trim($assetPath, " /\\");

                    print_r($assetFilePath . "<br>");

                    if (file_exists($assetFilePath)) {
                        // Generate an initialization function name by replacing directory separators with underscores
                        $pathParts = pathinfo($assetPath);
                        $combinedName = $pathParts['dirname'] . DIRECTORY_SEPARATOR . $pathParts['filename'];
                        $initFunctionName = preg_replace('/[\/\\\\]+/', '__', $combinedName);

                        $initFunctionContent = file_get_contents($assetFilePath);

                        if (strpos($initFunctionContent, $initFunctionName) === false) {
                            // Use pathinfo() to get the filename without the extension
                            $originalFileName = pathinfo($assetPath, PATHINFO_FILENAME);
                            
                            // Build a regex pattern that matches the function declaration of the original name
                            $pattern = '/function\s+' . preg_quote($originalFileName, '/') . '/';
                            $replacement = 'function ' . $initFunctionName;
                            
                            $updatedContent = preg_replace($pattern, $replacement, $initFunctionContent);

                            if ($updatedContent !== null) {
                                file_put_contents($assetFilePath, $updatedContent, LOCK_EX);
                            }
                        }

                        fwrite($mainFileHandle, $initFunctionName . "();\n");
                    }
                }

                fwrite($mainFileHandle, "});\n");
                fclose($mainFileHandle);
            }

            ?> 
                <script id="js-main" src="<?= DIRECTORY_SEPARATOR . $mainJSAsset ?>"></script>
            <?php

        echo ob_get_clean();
    }
}
