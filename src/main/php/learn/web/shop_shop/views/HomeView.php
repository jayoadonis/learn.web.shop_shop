<?php
declare(strict_types=1);

namespace learn\web\shop_shop\views;

use learn\web\shop_shop\controllers\HomeController;
use learn\web\shop_shop\models\Controller;
use learn\web\shop_shop\models\Status;
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
    public function init(): void {

        $this->controller->layout->title .= " ~ HOME";

        $this->controller->layout->cssManager->add("css-home-view", BaseDir::getResource("/public/resources/css/views/home_view.css"));
        
        $this->controller->layout->jsManager->add("js-home-view", BaseDir::getResource("/public/resources/js/views/home_view.js"));
        
    }

    public function render(): View|string|false {


        $paramPathID = $this->controller->layout->routeData?->param?->paramPath->get("id")->getOrElse(Status::UNKNOWN->value);
        $paramPathVERB = $this->controller->layout->routeData?->param?->paramPath->get("verb")->getOrElse("N/a");

        $queryID = $this->controller->layout->routeData?->param?->query->get("id")??"N/a";
        $queryCIty = $this->controller->layout->routeData?->param?->query->get("city")??"N/a";

        $heroIComponent = (new HeroI($this->controller))->render();

        $paramPathSurpise = $this->controller->layout->routeData->param->paramPath->surprise->getOrElse(Status::UNKNOWN->value);
        


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
                <div id="el-id-title-logo">
                    <span><img class="el-title-logo" src="/public/resources/img/music_app/logo/logo_001_160.png"/></span>HomeView...
                </div>
                <!-- <img src="/public/resources/img/bg.jpg"/> -->
                <?=$heroIComponent?>
                <h3>PARAM_PATHS: ID: `<?=$paramPathID?>` ~ VERB: `<?=$paramPathVERB?>`</h3>
                <h3>QUERIES: ID: `<?=$queryID?>` ~ City: `<?=$queryCIty?>`</h3>
                
                <button id="btn-test-1" type="button">test toast 1</button>
                <button id="btn-test-2" type="button">test toast 2</button>
                <button id="btn-test-3" class="center-notif" data-btn type="button">centerd</button>
                <?php
                //REM: Don't do this! Imminent Recursion.
                //REM: [FIXED] .|. Encapsulated.
                // echo $this->controller->layout->outlet->render()
                ?>
                <?php echo "::: " . $paramPathSurpise; ?>
            </div>
        <?php

        return ob_get_clean();
    }
}