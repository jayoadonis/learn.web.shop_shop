<?php
declare(strict_types=1);

namespace learn\web\shop_shop\views;

use learn\web\shop_shop\controllers\HomeController;
use learn\web\shop_shop\models\Controller;
use learn\web\shop_shop\models\View;


/**
 * 
 * @extends View<HomeController>
 */
class HomeView extends View {

    public function __construct( 
        HomeController $controller
    ) {

        parent::__construct($controller);
    }

    public function render(): View|string|false {

        $this->controller->fromHomeCtrl();

        $this->controller->layout->css["home-view-css"] = "";

        ob_start();
        ?>

        <?php

        return ob_get_clean();
    }
}