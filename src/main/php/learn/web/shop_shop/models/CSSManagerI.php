<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;

use function learn\web\shop_shop\utils\remove_trailing_whitespaces;

class CSSManagerI extends ClientSideCodeAsset {

    public function __construct() {
    
        parent::__construct();
    }

    /**
     * 
     * echo all the 'external CSS' and pop all the CSS resources found in the MEMORY...
     * {@inheritdoc}
     */
    protected function echoIt(): void {

        ob_start();

        ?>
            <?php foreach( $this->assets as $key => $assetPath ):?>

                <link id="<?=$key?>" rel="stylesheet" href="<?= DIRECTORY_SEPARATOR . $assetPath?>">
            <?php endforeach;?>
        <?php

        $cssAssetFilePath = ob_get_clean();

        remove_trailing_whitespaces( $cssAssetFilePath );

        echo $cssAssetFilePath;
    }
}