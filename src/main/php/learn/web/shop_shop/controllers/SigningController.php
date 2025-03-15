<?php
declare(strict_types=1);

namespace learn\web\shop_shop\controllers;

use learn\web\shop_shop\models\Controller;
use learn\web\shop_shop\models\Layout;
use learn\web\shop_shop\models\entities\User;
use learn\web\shop_shop\models\View;
use learn\web\shop_shop\utils\Session;
use learn\web\shop_shop\views\SigningView;

class SigningController extends Controller {


    public function __construct(
        Layout $layout
    ) {
        parent::__construct($layout);
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function init(): void {

    }

    /**
     * 
     * @inheritdoc
     */
    public function render(): View|string|false {

        if( Session::get(User::class) ) {

            header("Location: /home");
            // return false;
        }

        $signingViewRender = (new SigningView($this));


        ob_start();

        ?>
            <div id="html-signing-ctrl">
                <?= $signingViewRender->render() ?>
            </div>
        <?php

        return ob_get_clean();
    }
}