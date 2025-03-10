<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;

use learn\web\shop_shop\utils\BaseDir;

abstract class MiniCodeAsset extends ClientSideCodeAsset {

    public function __construct(
    
        protected $maxCombinedFileSize = 25000,
        protected $outputDirectory = "/public/resources/js/",
        protected $combinedFilePrefix = "combined_",
        protected $mainFileName = "main.js"
    
    ) {
        
        parent::__construct();
    }

    
    /**
     * Groups JS files so that the combined file size does not exceed the maxCombinedFileSize,
     * then combines and minifies the content of each group and writes them to new files.
     *
     * @return array An array of file paths for the combined JS files.
     */
    public function minifyJsAssets(): array {
        $groups = [];
        $currentGroup = [];
        $currentGroupSize = 0;
        
        //REM: Group files based on the size cap.
        foreach ($this->assets as $key => $assetPath) {

            if (!file_exists($assetPath)) {
                continue;
            }
            $size = filesize($assetPath);
            //REM: If adding this file would exceed the cap, store the current group and start a new one.
            if ($currentGroupSize + $size > $this->maxCombinedFileSize) {
                if (!empty($currentGroup)) {
                    $groups[] = $currentGroup;
                }
                $currentGroup = [$assetPath];
                $currentGroupSize = $size;
            } else {
                $currentGroup[] = $assetPath;
                $currentGroupSize += $size;
            }
        }
        //REM: Add any remaining files.
        if (!empty($currentGroup)) {
            $groups[] = $currentGroup;
        }
        
        //REM: Process each group: combine, minify, and write the output to a new file.
        $combinedFiles = [];
        foreach ($groups as $index => $group) {
            $combinedContent = '';
            foreach ($group as $filePath) {
                $combinedContent .= file_get_contents($filePath) . "\n";
            }
            
            //REM: Run a basic minification process (consider using a robust minifier for production).
            $minifiedContent = $this->minifyContent($combinedContent);
            
            //REM: Define the output file path.
            $outputFilePath = BaseDir::getRootPath() . $this->outputDirectory 
                              . $this->combinedFilePrefix . $index . ".js";
            file_put_contents($outputFilePath, $minifiedContent, LOCK_EX);
            $combinedFiles[] = $outputFilePath;
        }
        
        return $combinedFiles;
    }

    
    
    /**
     * A simple minification function that removes multi-line and single-line comments,
     * as well as extra whitespace. For production use, consider a dedicated minifier.
     *
     * @param string $content The JavaScript content to minify.
     * @return string The minified content.
     */
    protected function minifyContent(string $content): string {
        //REM: Remove multi-line comments.
        $content = preg_replace('#/\*.*?\*/#s', '', $content);
        //REM: Remove single-line comments.
        $content = preg_replace('#//.*#', '', $content);
        //REM: Remove extra whitespace.
        $content = preg_replace('/\s+/', ' ', $content);
        return trim($content);
    }

}