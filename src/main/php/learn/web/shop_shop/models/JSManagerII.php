<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;

use learn\web\shop_shop\utils\BaseDir;


class JSManagerII extends MiniCodeAsset {

    public function __construct(
        $maxCombinedFileSize = 25000,
        $outputDirectory = "/public/resources/js/",
        $combinedFilePrefix = "combined_",
        $mainFileName = "main.js"

    ) {
        parent::__construct(
            $maxCombinedFileSize,
            $outputDirectory,
            $combinedFilePrefix,
            $mainFileName
        );
    }
    
    /**
     * Echoes out the HTML with script tags that reference the combined, minified JS files.
     * Also, creates a main.js file which wraps asset loading inside a DOMContentLoaded event.
     */
    protected function echoIt(): void {
        ob_start();
        
        //REM: [TODO] .|. Don't know yet how to clarify it...
        //REM: Set and sanitize the current URL from the session and request URI.
        // $currentURL = isset($_SESSION["current_url"]) ? $_SESSION["current_url"] : "";
        // $_SESSION["current_url"] = trim(parse_url($_SERVER["REQUEST_URI"] ?? "/404", PHP_URL_PATH), "/");
        
        // //REM: Only proceed if the current URL has changed.
        // if ($currentURL !== $_SESSION["current_url"]) {
            //REM: Generate combined minified JS files.
            $combinedFiles = $this->minifyJsAssets();
            
            //REM: Create (or recreate) the main.js file.
            $mainFilePath = BaseDir::getRootPath() . $this->outputDirectory . $this->mainFileName;
            if (file_exists($mainFilePath)) {
                unlink($mainFilePath);
            }
            $mainFileHandle = fopen($mainFilePath, "a");
            if ($mainFileHandle !== false) {
                fwrite($mainFileHandle, "window.document.addEventListener('DOMContentLoaded', function(){\n");
                
                //REM: Output script tags for each combined file.
                foreach ($combinedFiles as $file) {
                    //REM: Adjust the file path to be relative (as needed by your project).
                    $src = str_replace(BaseDir::getRootPath(), '', $file);
                    echo '<script src="' . $src . '"></script>' . "\n";
                    fwrite($mainFileHandle, "/* " . $src . " loaded */\n");
                }
                
                fwrite($mainFileHandle, "});\n");
                fclose($mainFileHandle);
            }
        // }
        
        echo ob_get_clean();
    }
}
