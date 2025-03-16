<?php

declare(strict_types=1);

namespace learn\web\shop_shop\views\components;

use learn\web\shop_shop\controllers\HeaderController;
use learn\web\shop_shop\models\GymStoneURL;
use learn\web\shop_shop\models\entities\User;
use learn\web\shop_shop\models\View;
use learn\web\shop_shop\utils\BaseDir;
use learn\web\shop_shop\utils\Session;


/**
 * 
 * @extends View<HeaderController> [TODO]
 */
class Header extends View
{


    public function __construct(
        HeaderController $ctrl
    ) {
        parent::__construct($ctrl);
    }

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {

        $this->controller->layout->cssManager->add(
            "css-header-component",
            BaseDir::getResource("/public/resources/css/views/components/header_component.css")
        );
    }

    /**
     * {@inheritdoc}
     */
    public function render(): View|string|false
    {

        $_configs = require  BaseDir::getRootPath() . DIRECTORY_SEPARATOR . "config.php";

        $isSigningURL = ($this->controller->layout->routeData->path === GymStoneURL::SIGNING->getRootPath());

        $toggleThemeComponent = new ToggleComponent($this->controller);

        ob_start();
?>

        <div id="el-id-header-component" class="<?= $this ?>">

            <a href="/home" id="logo">
                <div id="el-id-title-logo">
                    <span><img class="el-title-logo" src="<?= BaseDir::getResource("/public/resources/img/music_app/logo/logo_001_160.png") ?>" /></span>
                    <span><?=__CONFIGS["general"]["app_name"]?></span>
                </div>
            </a>

            <div id="el-id-nav">
                <a href="/home/101/demo-button">demo-buton</a>

                <?php if (!$isSigningURL && !Session::get(User::class)): ?>
                    <a href="/signing">Subscribe</a>
                <?php endif; ?>

                <a href="/music-app">Music App</a>
            </div>

            <span><?= $toggleThemeComponent->render() ?></span>
        </div>
<?php

        return ob_get_clean();
    }
}
