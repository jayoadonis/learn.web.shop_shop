<?php
declare(strict_types=1);

namespace learn\web\shop_shop\controllers;

use learn\web\shop_shop\models\Controller;
use learn\web\shop_shop\models\View;
use learn\web\shop_shop\views\components\Header;

class HeaderController extends Controller {




    /**
     * {@inheritdoc}
     * 
     * @return View<HeaderController>|string|false 
     */
    public function render(): View|string|false {


        $headerComponent = (new Header($this))->render();

        ob_start();

        ?>
        <header id="el-header-ctrl" class="<?=$this?>">
            <?=$headerComponent?>
        </header>
        <?php

        return ob_get_clean();
    }
}