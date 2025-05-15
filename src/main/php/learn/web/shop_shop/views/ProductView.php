<?php
declare(strict_types=1);

namespace learn\web\shop_shop\views;

use learn\web\shop_shop\models\View;
use learn\web\shop_shop\controllers\ProductController;
use learn\web\shop_shop\utils\BaseDir;

/**
 * 
 * @extends View<ProductController>
 */
class ProductView extends View {

    /**
     * 
     *{@inheritdoc} 
     */
    public function init(): void {

        $this->controller->layout->cssManager->add(
            "css-product-view",
            BaseDir::getResource("/public/resources/css/views/product_view.css")
        );

        $this->controller->layout->jsManager->add(
            "js-product-view",
            BaseDir::getResource("/public/resources/js/views/product_view.js")
        );
    }

    /**
     * {@inheritdoc}
     */
    public function render(): View|string|false {

        ob_start();
        ?>
        <div id="el-id-product-view">
            
        </div>
        <?php
        return ob_get_clean();
    }
}