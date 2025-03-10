<?php
declare(strict_types=1);

namespace learn\web\shop_shop\controllers;

use learn\web\shop_shop\misc\music_app\views\components\MusicHeaderComponent;
use learn\web\shop_shop\models\Controller;
use learn\web\shop_shop\models\GymStoneURL;
use learn\web\shop_shop\models\View;
use learn\web\shop_shop\views\components\Header;

class HeaderController extends Controller {


    /**
     * {@inheritdoc}
     * 
     * @return View<HeaderController>|string|false 
     */
    public function render(): View|string|false {


        $isMusicAppURL = ( $this->layout->routeData->path === GymStoneURL::MUSIC_APP->getRootPath() );

        $normalHeader = new Header($this);

        $musicHeader = new MusicHeaderComponent($this);

        ob_start();

        ?>
        <header id="el-header-ctrl" class="<?=$this?>">
            <?php if( !$isMusicAppURL ): ?>
                <?= $normalHeader->render() ?>
            <?php else:?>
                <?= $musicHeader->render() ?>
            <?php endif;?>
        </header>
        <?php

        return ob_get_clean();
    }
}