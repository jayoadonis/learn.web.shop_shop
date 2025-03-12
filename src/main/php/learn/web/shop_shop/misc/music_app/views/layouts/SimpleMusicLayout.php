<?php

declare(strict_types=1);

namespace learn\web\shop_shop\misc\music_app\views\layouts;

use learn\web\shop_shop\misc\music_app\controllers\SImpleMusicHeaderController;
use learn\web\shop_shop\models\IRenderer;
use learn\web\shop_shop\models\Layout;
use learn\web\shop_shop\models\View;
use learn\web\shop_shop\utils\BaseDir;

class SimpleMusicLayout extends Layout
{


    public function __construct(string $title)
    {

        parent::__construct($title);
    }

    /**
     * @inheritDoc Layout::render(): View|string|false
     */
    public function render(): View|string|false
    {

        //REM: [TODO] .|. Refactor it later...
        if( session_status() === PHP_SESSION_NONE ) {
            session_start();
        }
        //REM: [TODO] .|. Refactor it later...
        if ( !isset($_SESSION['theme']) ) {
            $_SESSION['theme'] = 'light';
        }

        $this->cssManager->add("css-toast", BaseDir::getResource("/public/resources/css/components/toast.css"));
        $this->jsManager->add("js-toast", BaseDir::getResource("/public/resources/js/view/components/toast.js"));
        
        $this->cssManager->add("css-toast_i", BaseDir::getResource("/public/resources/css/components/toast_i.css"));
        $this->jsManager->add("js-toast_i", BaseDir::getResource("/public/resources/js/view/components/toast_i.js"));
        
        
        // $headerCtrl = (new HeaderController($this))->render();
        $musicHeaderCtrl = (new SImpleMusicHeaderController($this))->render();

        //REM: Contronller rendering...
        $outlet = ($this->outlet instanceof IRenderer) ? $this->outlet->render() : $this->outlet;

        ob_start();
        ?>
            <!DOCTYPE html>

            <html lang="en" 
            data-color-theme="<?=htmlspecialchars($_SESSION["theme"], ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8')?>">

            <!-- <html lang="en"> -->

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                
                <link id="css-global" rel="stylesheet" href="/public/resources/css/global.css">
                
                <?= $this->cssManager->echoIt() ?>
                
                <title><?= $this->title ?></title>
            </head>

            <body id="el-simple-layout">
                
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

                <script id="js-util-hasher" src="/public/resources/js/utils/hasher.js"></script>
                <?= $this->jsManager->exhaustIt() ?>
            </body>

            </html>

        <?php

        return ob_get_clean();
    }
}
