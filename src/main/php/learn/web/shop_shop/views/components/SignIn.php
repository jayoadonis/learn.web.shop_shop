<?php
declare(strict_types=1);

namespace learn\web\shop_shop\views;

use learn\web\shop_shop\models\View;
use learn\web\shop_shop\models\Controller;


/**
 * 
 * 
 * @extends View<Controller>
 */
class SignIn extends View {

    
    /**
     * 
     * @inheritdoc
     */
    public function init(): void {
        
    }

    /**
     * 
     * @inheritdoc
     */
    public function render(): View|string|false {


        ob_start();

        ?>
        
        <div id="">
            <h1>Sign In</h1>
        </div>

        <?php

        return ob_get_clean();
    }

}