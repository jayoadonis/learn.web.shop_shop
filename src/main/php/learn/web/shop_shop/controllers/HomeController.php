<?php
declare(strict_types=1);

namespace learn\web\shop_shop\controllers;

use learn\web\shop_shop\models\Controller;
use learn\web\shop_shop\models\Layout;
use learn\web\shop_shop\models\View;
use learn\web\shop_shop\views\HomeView;

class HomeController extends Controller {

    public function __construct(
        Layout $layout
    ) {
        parent::__construct($layout);

    }

    /**
     * @inheritDoc Controller::render()
     */
    public function render(): View|String|false {

        ob_start();

        ?>
        
        <?=(new HomeView($this))->render()?>

        <?php
        
        return ob_get_clean();
    }

    public function fromHomeCtrl(): void {


    }
}