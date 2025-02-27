<?php
declare(strict_types=1);

namespace learn\web\shop_shop\views\components;

use learn\web\shop_shop\models\Controller;
use learn\web\shop_shop\models\View;
use learn\web\shop_shop\utils\BaseDir;

/**
 * 
 * @extends View<Controller>
 */
class HeroI extends View {

    public function render(): View|string|false {

        $this->controller->layout->cssManager->add("css-hero-i-component", BaseDir::getResource("/public/resources/css/components/hero_i_component.css"));

        ob_start();

        ?>
        <div id="el-hero-i-component" class="<?=$this?>">
            <h1>Hero I</h1>
        </div>
        <?php

        return ob_get_clean();
    }
}