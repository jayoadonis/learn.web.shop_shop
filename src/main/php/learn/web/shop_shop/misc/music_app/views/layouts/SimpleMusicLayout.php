<?php

declare(strict_types=1);

namespace learn\web\shop_shop\misc\music_app\views\layouts;

use learn\web\shop_shop\misc\music_app\controllers\SImpleMusicHeaderController;
use learn\web\shop_shop\models\IRenderer;
use learn\web\shop_shop\models\Layout;
use learn\web\shop_shop\models\View;
use learn\web\shop_shop\utils\BaseDir;
use learn\web\shop_shop\utils\Session;

class SimpleMusicLayout extends Layout
{


    public function __construct(string $title)
    {

        parent::__construct($title);
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function init(): void {

        $this->cssManager->add(
            "css-global",
            BaseDir::getResource("/public/resources/css/global.css")
        );

        $this->jsManager->add(
            "js-utils-global",
            BaseDir::getResource("/public/resources/js/utils/global.js")
        );
        $this->jsManager->add(
            "js-utils-hasher",
            BaseDir::getResource("/public/resources/js/utils/hasher.js")
        );

        $this->cssManager->add("css-toast", BaseDir::getResource("/public/resources/css/views/components/toast.css"));
        $this->jsManager->add("js-toast", BaseDir::getResource("/public/resources/js/views/components/toast.js"));
        
        $this->cssManager->add("css-toast_i", BaseDir::getResource("/public/resources/css/views/components/toast_i.css"));
        $this->jsManager->add("js-toast_i", BaseDir::getResource("/public/resources/js/views/components/toast_i.js"));
        
    }

    /**
     * @inheritDoc Layout::render(): View|string|false
     */
    public function render(): View|string|false
    {

        // //REM: [TODO] .|. Refactor it later...
        // if( session_status() === PHP_SESSION_NONE ) {
        //     session_start();
        // }
        // //REM: [TODO] .|. Refactor it later...
        // if ( !isset($_SESSION['theme']) ) {
        //     $_SESSION['theme'] = 'light';
        // }

        if( Session::get("theme") === null ) {

            Session::setWithExplicitId("theme", "light");
        }
        
        
        // $headerCtrl = (new HeaderController($this))->render();
        $musicHeaderCtrl = (new SImpleMusicHeaderController($this))->render();

        //REM: Contronller rendering...
        $outlet = ($this->outlet instanceof IRenderer) ? $this->outlet->render() : $this->outlet;

        ob_start();
        ?>
            <!DOCTYPE html>

            <html lang="en" 
            data-color-theme="<?=htmlspecialchars(Session::get("theme")??"light", ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8')?>">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                
                <?= $this->cssManager->exhaustIt() ?>
                
                <title><?= $this->title ?></title>
            </head>

            <body id="el-id-body-simple-music-layout">
                
                <?= $musicHeaderCtrl ?>

                <section id="el-main">
                    <?= $outlet ?>
                </section>

                <footer>
                    <div class="footer-content">
                        <p>Come enjoy with music with us</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </footer>

                <?= $this->jsManager->exhaustIt() ?>
            </body>

            </html>

        <?php

        return ob_get_clean();
    }
}
