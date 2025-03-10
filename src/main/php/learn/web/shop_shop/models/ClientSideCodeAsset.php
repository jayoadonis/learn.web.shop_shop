<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;


abstract class ClientSideCodeAsset extends ObjectI {


    /**
     * 
     * @var array<string,string> $assets
     */
    protected array $assets;
    protected int $size;

    public function __construct() {

        $this->assets = [];
        $this->size = 0;
    }

    protected abstract function echoIt(): void;

    /**
     * 
     * Echo and then clean js file script resources
     */
    public function exhaustIt(): void {
        $this->echoIt();
        flush(); //REM: [TODO] .|. This will immediately response back the "Output Buff" to the client side...
        $this->clean();
    }

    public function clean(): void {
        unset( $this->assets );
        $this->assets = [];
        $this->size = 0;
    }

    public function add( string $key, string $assetPath ): bool {

        if( ! array_key_exists($key, $this->assets) ) {

            $this->assets[$key] = trim( $assetPath, " /\\");
            $this->size++;

            return true;
        }

        return false;
    }

}