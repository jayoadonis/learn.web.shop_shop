<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;

use function learn\web\shop_shop\utils\remove_trailing_whitespaces;

class JSManager extends ClientSideCodeAsset {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    protected function echoIt(): void {
        ob_start();
        
        
?>
        <?php foreach( $this->assets as $key => $assetPath ): ?>

            <script id="<?=$key?>" src="<?=DIRECTORY_SEPARATOR . $assetPath?>"></script>
        <?php endforeach; ?>
<?php

        $jsAssetFilePath = ob_get_clean();

        remove_trailing_whitespaces( $jsAssetFilePath );

        echo $jsAssetFilePath;
    }
}
