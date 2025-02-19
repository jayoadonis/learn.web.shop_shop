<?php
declare(strict_types=1);

namespace learn\web\shop_shop\controllers;

use learn\web\shop_shop\models\Controller;
use learn\web\shop_shop\models\Layout;
use learn\web\shop_shop\models\View;
use learn\web\shop_shop\utils\LogType;
use learn\web\shop_shop\views\HomeView;

use learn\web\shop_shop\utils\Log;

class HomeController extends Controller {

    // public static $count = 0;
    
    public function __construct(
        Layout $layout,
    ) {
        parent::__construct($layout);
        // HomeController::$count++;
        // echo strtr("HomeController instantiated <n> times\n", ["<n>" => HomeController::$count]);
    }

    /**
     * @inheritDoc Controller::render()
     */
    public function render(): View|String|false {

        $homeViewRendered = (new HomeView($this))->render();


        ob_start();
        ?>
        
            <div id="html-home-controller">
                <?=$homeViewRendered?>
            </div>

        <?php
        return ob_get_clean();
    }

    public function fromHomeCtrl(): void {

        // Log::log(LogType::INFO, "Home Controller...");
    }
}