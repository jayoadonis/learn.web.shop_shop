<?php
declare(strict_types=1);

namespace learn\web\shop_shop\views\components;

use learn\web\shop_shop\controllers\HeaderController;
use learn\web\shop_shop\models\View;
use learn\web\shop_shop\utils\BaseDir;

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


        $this->controller->layout->cssManager->add(
            "css-toggle-theme",
            BaseDir::getResource("/public/resources/css/toggle_theme.css")
        );

        $this->controller->layout->jsManager->add(
            "js-toggle-theme",
            BaseDir::getResource("/public/resources/js/toggle_theme.js")
        );

        ob_start();
        ?>

        <div id="el-header-component" class="<?=$this?>">
            <h1>Header...123</h1>
            <lable id="toggle-theme-container" class="el-toggle-theme-container" type="button">
                <input id="toggle-theme" type="checkbox" aria-label="toggle theme"/>
                <span id="toggle-theme-slider" class="el-toggle-theme-slider" ></span>
            </lable>
        </div>
        <?php

        return ob_get_clean();
    }
}