<?php
declare(strict_types=1);

namespace learn\web\shop_shop\controllers;

use learn\web\shop_shop\models\View;
use learn\web\shop_shop\models\Controller;
use learn\web\shop_shop\views\ProductView;

class ProductController extends Controller {

    /**
     * 
     * {@inheritdoc}
     */
    public function init(): void {

    }

    /**
     * {@inheritdoc}
     */
    public function render(): View|string|false {

        $productView = (new ProductView($this));

        ob_start();
        ?>
        <div id="el-id-product-controller">
            <?= $productView->render() ?>
        </div>
        <?php
        return ob_get_clean();
    }
}