<?php
declare(strict_types=1);

namespace learn\web\shop_shop\controllers;

use learn\web\shop_shop\models\Controller;
use learn\web\shop_shop\models\View;

class MappyController extends Controller {



    /**
     * 
     * {@inheritdoc}
     */
    public function init(): void {

    }

    /**
     * 
     * {@inheritdoc}
     */
    public function render(): View|string|false {

        ob_start();

        return ob_get_clean();
    }
}