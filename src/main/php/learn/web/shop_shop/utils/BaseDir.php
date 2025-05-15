<?php

declare(strict_types=1);

namespace learn\web\shop_shop\utils;

use learn\web\shop_shop\models\ObjectI;

/**
 * 
 */
class BaseDir extends ObjectI
{

    private static BaseDir|null $baseDir = null;

    private readonly string $rootPath;

    /**
     * 
     * @var array<string> 
     */
    private array $blackListedFilePaths;

    /**
     * 
     * @var array<string>
     */
    private array $whiteListedFilePaths;

    /**
     * 
     * @param array<string> $blackListedFilePaths
     * @param array<string> $whiteListedFilePaths
     */
    private function __construct(
        string $rootPath,
        array $blackListedFilePaths = [],
        array $whiteListedFilePaths = []
    ) {

        $realRootPath = realpath($rootPath);

        if ($realRootPath === false || !is_dir($realRootPath)) {

            throw new \RuntimeException("Invalid Base Directory.");
        }
            
        $charStrip = " \n\r\t\v/\\";

        $this->rootPath = rtrim($realRootPath, $charStrip);

        $this->blackListedFilePaths = [];
        $this->whiteListedFilePaths = [];

        foreach ($blackListedFilePaths as $blackListedPath) {
            $blackListedFullPath = realpath(
                $this->rootPath . DIRECTORY_SEPARATOR
                    . ltrim($blackListedPath, $charStrip)
            );
            if ($blackListedFullPath !== false)
                $this->blackListedFilePaths[] = $blackListedFullPath;
        }

        foreach ($whiteListedFilePaths as $whiteListedPath) {
            $whiteListedFullPath = realpath(
                $this->rootPath . DIRECTORY_SEPARATOR
                    . ltrim($whiteListedPath, $charStrip)
            );
            if ($whiteListedFullPath !== false)
                $this->whiteListedFilePaths[] = $whiteListedFullPath;
        }

    }

    public static function getRootPath(): string {

        if( BaseDir::$baseDir === null ) 
            throw new \RuntimeException("Instantiation Exception: " . (self::class) );

        return BaseDir::$baseDir->rootPath;
    }

    public static function getInstance(
        string $rootPath,
        array|null $blackListedFilePaths = ["src/"],
        array|null $whiteListedFilePaths = ["src/main/resources/"]
    ): BaseDir {

        if (BaseDir::$baseDir === null)
            BaseDir::$baseDir = new BaseDir($rootPath, $blackListedFilePaths ?? [], $whiteListedFilePaths ?? []);
        
        return BaseDir::$baseDir;
    }

    private function resolvePath(string $subPath): string
    {

        if( /* preg_match("/^[\/\\\\]+/", $subPath) || */ preg_match("/^[a-zA-Z0-9 -]+:[\/\\\\]?+/i", $subPath) ) {

            throw new \RuntimeException("Access denied: Absolute path is not allowed '{$subPath}'");
        }

        $charStrip = " \n\r\t\v/\\\\";

        $fullPath = realPath(
            $this->rootPath . DIRECTORY_SEPARATOR
            . ltrim( $subPath, $charStrip )
        );

        if( $fullPath === false || strpos($fullPath, $this->rootPath) !== 0 ) {
            throw new \RuntimeException("Access denied: Invalid path '{$subPath}'");
        }

        foreach( $this->blackListedFilePaths as $blackListedPath ) {
            if( strpos($fullPath, $blackListedPath) === 0 ) {
                $allowedPath = false;
                foreach( $this->whiteListedFilePaths as $whiteListedPath ) {
                    if( strpos($fullPath, $whiteListedPath ) === 0 ) {
                        $allowedPath = true;
                        break;
                    }
                }
                if(!$allowedPath) {
                    throw new \RuntimeException("Access denied: Path is black listed '{$subPath}'");
                }
            }
        }

        return $fullPath;
    }


    /**
     * Normalize a path by removing extra slashes, '.' and '..' segments.
     * This does not check file existence; it simply canonicalizes the path.
     */
    private function normalizePath(string $path): string
    {
        $parts = [];
        $segments = preg_split('/[\/\\\\]+/', $path);
        foreach ($segments as $segment) {
            if ($segment === '' || $segment === '.') {
                continue;
            }
            if ($segment === '..') {
                array_pop($parts);
            } else {
                $parts[] = $segment;
            }
        }
        //REM: Rebuild the path using DIRECTORY_SEPARATOR.
        //REM: If $path was absolute, you might need to prepend a slash (or drive letter).
        return implode(DIRECTORY_SEPARATOR, $parts);
    }

    /**
     * 
     * Return valid relative file path...
     */
    public static function getResource(string $subPath): string {

        if( BaseDir::$baseDir === null )
            throw new \RuntimeException("Instantation Exception: " . self::class);

        return BaseDir::$baseDir->getRelativePath( $subPath );
    }

    public function getRelativePath(string $subPath): string
    {

        $fullPath = $this->resolvePath($subPath);

        if (!file_exists($fullPath))
            throw new \RuntimeException("Path does not exists: '{$subPath}'");

        $relativePath = DIRECTORY_SEPARATOR . substr($fullPath, strlen($this->rootPath) + 1);

        return is_dir($fullPath)
            ? rtrim($relativePath, " \n\r\t\v/\\") . DIRECTORY_SEPARATOR
            : $relativePath;
    }
}

/**
 * 
 * @template K
 * @template V
 */
interface IPair {

    /**
     * @return K
     */
    public function getKey(): mixed;

    /**
     * @return V
     */
    public function getValue(): mixed;
}
