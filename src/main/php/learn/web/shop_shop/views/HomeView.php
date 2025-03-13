<?php
declare(strict_types=1);

namespace learn\web\shop_shop\views;

use learn\web\shop_shop\controllers\HomeController;
use learn\web\shop_shop\models\Controller;
use learn\web\shop_shop\models\User;
use learn\web\shop_shop\models\View;
use learn\web\shop_shop\utils\BaseDir;
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
    
    /**
     * 
     * {@inheritdoc}
     */
    protected function init(): void {
        
    }

    public function render(): View|string|false {

        // $this->controller->fromHomeCtrl();

        // $this->controller->layout->css["css-home-view"] = "/public/resources/css/home_view.css";

        $this->controller->layout->cssManager->add("css-home-view", BaseDir::getResource("/public/resources/css/views/home_view.css"));
        
        $this->controller->layout->jsManager->add("js-home-view", BaseDir::getResource("/public/resources/js/views/home_view.js"));

        $paramPathID = $this->controller->layout->routeData->param?->paramPath->get("id")??"N/a";
        $paramPathVERB = $this->controller->layout->routeData->param?->paramPath->get("verb")??"N/a";

        $queryID = $this->controller->layout->routeData->param?->query->get("id")??"N/a";
        $queryCIty = $this->controller->layout->routeData->param?->query->get("city")??"N/a";

        $heroIComponent = (new HeroI($this->controller))->render();


        // $this->controller->fromHomeCtrl();

        // $this->controller->addActionListener( $this );
        // $this->controller->dispatchActionListener( $this, "btn-i");

        
        // $x = Session::get( User::class );

        // echo ($x ?? "none"). "<br>";
        // echo ($x?->ID ?? "none"). "<br>";
        // echo ($x?->USER_NAME ?? "none" ). "<br>";
        // echo ($x?->getEmail() ?? "none" ). "<br>";
        // echo ($x?->TYPE ?? "none" ). "<br>";
        
        ob_start();
        ?>
            <div id="el-home-view" class="<?=$this?>">
                <h1>HomeView...</h1>
                <!-- <img src="/public/resources/img/bg.jpg"/> -->
                <?=$heroIComponent?>
                <h3>PARAM_PATHS: ID: `<?=$paramPathID?>` ~ VERB: `<?=$paramPathVERB?>`</h3>
                <h3>QUERIES: ID: `<?=$queryID?>` ~ City: `<?=$queryCIty?>`</h3>
                
                <button id="btn-test-1" type="button">test toast 1</button>
                <button id="btn-test-2" type="button">test toast 2</button>
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