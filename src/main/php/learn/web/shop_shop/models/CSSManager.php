<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;


class CSSManager extends ObjectI {

    /**
     * 
     * @var array<string,string> $css
     */
    private array $css;

    private int $size;

    public function __construct() {
        $this->css = [];
        $this->size = 0;
    }


    /**
     * 
     * @return array<string,string>
     */
    public function fetchAll(): array {
        if( ! isset( $this->css ) ) {

        }
        return $this->css;
    }

    public function getSize(): int {

        return $this->size;
    }

    /**
     * 
     * echo all the 'external CSS' and pop all the CSS resources found in the MEMORY...
     */
    public function echoIt(): void {

        ob_start();

        ?>
            <?php foreach( $this->fetchAll() as $key => $path ):?>
                <link id="<?=$key?>" rel="stylesheet" href="<?= DIRECTORY_SEPARATOR . $path?>">
            <?php endforeach;?>
        <?php

        unset( $this->css );
        $this->css = [];
        $this->size = 0;

        echo ob_get_clean();
    }

    public function add( string $key, string $path ): bool {

        if( !array_key_exists($key, $this->css) ) {
            $this->css[$key] = $path;
            $this->size++;
            return true;
        }
        return false;
    }

    public function remove( string $key ): bool {

        if( array_key_exists($key, $this->css) ) {

            unset( $this->css[$key] );
            $this->size--;
            return true;
        }

        return false;
    }
}