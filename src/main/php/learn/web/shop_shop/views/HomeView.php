<?php
declare(strict_types=1);

namespace learn\web\shop_shop\views;

use learn\web\shop_shop\controllers\HomeController;
use learn\web\shop_shop\models\Controller;
use learn\web\shop_shop\models\User;
use learn\web\shop_shop\models\View;
use learn\web\shop_shop\utils\Session;
use learn\web\shop_shop\views\components\HeroI;

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

        $this->controller->layout->css["css-home-view"] = "/public/resources/css/home_view.css";

        $paramPathID = $this->controller->layout->routeData->param?->paramPath->get("id")??"N/a";
        $paramPathVERB = $this->controller->layout->routeData->param?->paramPath->get("verb")??"N/a";

        $queryID = $this->controller->layout->routeData->param?->query->get("")??"N/a";
        $queryCODE = $this->controller->layout->routeData->param?->query->get("code")??"N/a";

        $heroIComponent = (new HeroI($this->controller))->render();


        // $this->controller->fromHomeCtrl();

        
        ob_start();
        ?>
            <div id="html-home-view" class="<?=$this->hashCode()?>">
                <div id="hero">

                </div>
                <h1>HomeView</h1>
                <h3>PARAM_PATHS: ID: `<?=$paramPathID?>` ~ VERB: `<?=$paramPathVERB?>`</h3>
                <h3>QUERIES: ID: `<?=$queryID?>` ~ CODE: `<?=$queryCODE?>`</h3>
                <?=$heroIComponent?>
                
                <?php
                //REM: Don't do this! Imminent Recursion.
                //REM: [FIXED] .|. Encapsulated.
                // echo $this->controller->layout->outlet->render()
                ?>
                
            </div>
        <?php

        return ob_get_clean();
    }
}