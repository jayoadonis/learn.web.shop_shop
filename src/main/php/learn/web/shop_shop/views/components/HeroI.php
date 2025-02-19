<?php
declare(strict_types=1);

namespace learn\web\shop_shop\views\components;

use learn\web\shop_shop\models\Controller;
use learn\web\shop_shop\models\View;

/**
 * 
 * @extends View<Controller>
 */
class HeroI extends View {

    public function render(): View|string|false {

        $this->controller->layout->css["css-hero-i-component"] = "/public/resources/css/components/hero_i_component.css";

        ob_start();

        ?>
        <div id="html-hero-i-component">
            <h1>Hero I</h1>
        </div>
        <?php

        return ob_get_clean();
    }
}