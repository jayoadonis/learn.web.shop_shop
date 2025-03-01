<?php

declare(strict_types=1);

namespace learn\web\shop_shop\views\layouts;

use learn\web\shop_shop\controllers\HeaderController;
use learn\web\shop_shop\models\IRenderer;
use learn\web\shop_shop\models\Layout;
use learn\web\shop_shop\models\View;
use learn\web\shop_shop\utils\BaseDir;

class SimpleLayout extends Layout
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

        $this->cssManager->add("css-toast", BaseDir::getResource("/public/resources/css/components/toast.css"));
        $this->jsManager->add("js-toast", BaseDir::getResource("/public/resources/js/view/components/toast.js"));
        
        
        $headerCtrl = (new HeaderController($this))->render();
        $outlet = ($this->outlet instanceof IRenderer) ? $this->outlet->render() : $this->outlet;

        ob_start();
        ?>
            <!DOCTYPE html>

            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                
                <link id="css-global" rel="stylesheet" href="/public/resources/css/global.css">
                <link id="css-component-toast-i" rel="stylesheet" href="/public/resources/css/components/toast_i.css">
                
                <?= $this->cssManager->echoIt() ?>
                
                <title><?= $this->title ?></title>
            </head>

            <body id="el-simple-layout">
                
                <?= $headerCtrl ?>

                <section id="el-main">
                    <?= $outlet ?>
                </section>

                <footer>

                </footer>

                <script id="js-util-hasher" src="/public/resources/js/utils/hasher.js"></script>
                <script id="js-view-component-toast-i" src="/public/resources/js/view/components/toast_i.js"></script>
                <?= $this->jsManager->useIt() ?>
            </body>

            </html>

        <?php

        return ob_get_clean();
    }
}
