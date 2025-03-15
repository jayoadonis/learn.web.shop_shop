<?php

declare(strict_types=1);

namespace learn\web\shop_shop\views\layouts;

use learn\web\shop_shop\controllers\HeaderController;
use learn\web\shop_shop\models\IRenderer;
use learn\web\shop_shop\models\Layout;
use learn\web\shop_shop\models\View;
use learn\web\shop_shop\utils\BaseDir;
use learn\web\shop_shop\utils\Session;

class SimpleLayout extends Layout
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

        $this->cssManager->add(
            "css-simple-layout",
            BaseDir::getResource("/public/resources/css/views/layouts/simple_layout.css")
        );


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
        
        
        $headerCtrl = (new HeaderController($this))->render();

        //REM: Contronller rendering main...
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

            <body id="el-id-body-simple-layout">
                
                <?= $headerCtrl ?>

                <section id="el-id-main">
                    <?= $outlet ?>
                </section>

                <footer>
                    <h1>Footer...</h1>
                </footer>

                <?= $this->jsManager->exhaustIt() ?>
            </body>

            </html>

        <?php

        return ob_get_clean();
    }
}
