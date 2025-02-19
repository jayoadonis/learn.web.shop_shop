<?php
declare(strict_types=1);

namespace learn\web\shop_shop\controllers;

use learn\web\shop_shop\models\Controller;
use learn\web\shop_shop\models\View;
use learn\web\shop_shop\models\Layout;
use learn\web\shop_shop\views\DashboardView;

class DashboardController extends Controller {


    public function __contruct(
        Layout $layout
    ) {
        parent::__construct($layout);
    }
    /**
     * 
     * @inheritDoc
     */
    public function render(): View|string|false {

        $dashboardViewRender = (new DashboardView($this))->render();

        ob_start();
        ?>
            <div id="html-dashboard-controller">
                <?=$dashboardViewRender?>
            </div>
        <?php
        return ob_get_clean();
    }
}