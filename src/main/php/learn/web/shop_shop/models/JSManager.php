<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;

use LanguageServerProtocol\InitializeResult;
use learn\web\shop_shop\models\routes\Router;
use learn\web\shop_shop\utils\BaseDir;
use learn\web\shop_shop\utils\Session;

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
        

        echo ob_get_clean();
    }
}
