<?php
declare(strict_types=1);


namespace learn\web\shop_shop\views\components;

use learn\web\shop_shop\models\Component;
use learn\web\shop_shop\models\View;
use learn\web\shop_shop\utils\BaseDir;

class ToggleComponent extends Component {


    /**
     * 
     * 
     * {@inheritdoc}
     */
    protected function init(): void {
        
        $this->controller->layout->cssManager->add(
            "css-toggle-theme",
            BaseDir::getResource("/public/resources/css/views/components/toggle_theme.css")
        );

        $this->controller->layout->jsManager->add(
            "js-toggle-theme",
            BaseDir::getResource("/public/resources/js/views/components/toggle_theme.js")
        );

    }

    /**
     * 
     * {@inheritdoc}
     */
    public function render(): View|string|false {

        ob_start();
        ?>
        <lable id="el-id-toggle-theme-container" class="el-toggle-theme-container" type="button">
            <input id="el-id-toggle-theme" type="checkbox" aria-label="toggle theme"/>
            <span id="el-id-toggle-theme-slider" class="el-toggle-theme-slider" ></span>
        </lable>
        <?php

        return ob_get_clean();
    }
}