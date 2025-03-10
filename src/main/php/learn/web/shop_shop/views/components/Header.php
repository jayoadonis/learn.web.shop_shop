<?php
declare(strict_types=1);

namespace learn\web\shop_shop\views\components;

use learn\web\shop_shop\controllers\HeaderController;
use learn\web\shop_shop\models\GymStoneURL;
use learn\web\shop_shop\models\User;
use learn\web\shop_shop\models\View;
use learn\web\shop_shop\utils\BaseDir;
use learn\web\shop_shop\utils\Session;

/**
 * 
 * @extends View<HeaderController> [TODO]
 */
class Header extends View {


    public function __construct(
        HeaderController $ctrl
    ) {
        parent::__construct($ctrl);
    }

    /**
     * {@inheritdoc}
     */
    protected function init(): void {

        $this->controller->layout->cssManager->add(
            "css-header-component",
            BaseDir::getResource("/public/resources/css/views/components/header_component.css")
        );
    }

    /**
     * {@inheritdoc}
     */
    public function render(): View|string|false {


        $isSigningURL= ( $this->controller->layout->routeData->path === GymStoneURL::SIGNING->getRootPath() );

        $toggleThemeComponent = new ToggleComponent($this->controller);

        ob_start();
        ?>

        <div id="el-id-header-component" class="<?=$this?>">
            <a href="/home" id="logo"><h1>Header...123</h1></a>
            <?= $toggleThemeComponent->render() ?>
            <a href="/home/101/demo-button">demo-buton</a>
            <?php if( !$isSigningURL && !Session::get(User::class) ): ?>
                <a href="/signing">Subscribe</a>
            <?php endif; ?>
            <a href="/music-app">Music App</a>
        </div>
        <?php

        return ob_get_clean();
    }
}