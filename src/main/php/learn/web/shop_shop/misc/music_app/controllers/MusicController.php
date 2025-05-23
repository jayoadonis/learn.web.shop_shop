<?php
declare(strict_types=1);

namespace learn\web\shop_shop\misc\music_app\controllers;

use learn\web\shop_shop\misc\music_app\views\LandingPage;
use learn\web\shop_shop\models\Controller;
use learn\web\shop_shop\models\Layout;
use learn\web\shop_shop\models\Status;
use learn\web\shop_shop\models\VIew;



class MusicController extends Controller {


    public function __construct(
        Layout $layout
    ) {
        parent::__construct($layout);
    }

    /**
     * {@inheritdoc}
     */
    public function init(): void {
        
    }

    /**
     * 
     * {@inheritdoc}
     */
     public function render(): View|string|false {

        $paramPathVerb = $this->layout->routeData->param->paramPath->verb->getOrElse(Status::UNKNOWN->value);

        ob_start();

        ?>
        
        <?=(new LandingPage($this))->render()?>

        <?php

        return ob_get_clean();
     }
}