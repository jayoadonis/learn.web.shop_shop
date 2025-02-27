<?php
declare(strict_types=1);

namespace learn\web\shop_shop\views\components;

use learn\web\shop_shop\controllers\HeaderController;
use learn\web\shop_shop\models\View;

/**
 * 
 * @extends View<HeaderController> [TODO]
 */
class Header extends View {


    public function __construct(
        HeaderController $ctrl
    ) {
        parent::__construct($ctrl);
    }

    /**
     * {@inheritdoc}
     */
    public function render(): View|string|false {


        ob_start();
        ?>

        <div id="el-header-component" class="<?=$this?>">
            <h1>Header...123</h1>
        </div>
        <?php

        return ob_get_clean();
    }
}