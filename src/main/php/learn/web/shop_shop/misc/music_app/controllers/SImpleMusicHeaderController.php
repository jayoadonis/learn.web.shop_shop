<?php
declare(strict_types=1);

namespace learn\web\shop_shop\misc\music_app\controllers;

use learn\web\shop_shop\misc\music_app\views\components\MusicHeaderComponent;
use learn\web\shop_shop\models\View;
use learn\web\shop_shop\models\Controller;


class SImpleMusicHeaderController extends Controller {

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
        ?>
        
        <?= (new MusicHeaderComponent($this))->render() ?>

        <?php
        return ob_get_clean();
    }

}