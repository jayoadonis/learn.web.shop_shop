<?php
declare(strict_types=1);

namespace learn\web\shop_shop\views\layouts;

use learn\web\shop_shop\models\Layout;
use learn\web\shop_shop\models\View;

class SimpleLayout extends Layout {

    public function __construct( string $title ) {

        parent::__construct( $title );
    }

    /**
     * @inheritDoc Layout::render(): View|string|false
     */
    public function render(): View|string|false {

        ob_start();
        
        ?>
        
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="">
                <?php
                foreach( $this->css as $key => $value ) {
                ?>
                <link id="<?=$key?>" rel="stylesheet" href="<?=$value?>">
                <?php
                }
                ?>
            </head>
            <body>
                <?=$this->outlet->render()?>
            </body>
        </html>

        <?php

        return ob_get_clean(); 
    }
}