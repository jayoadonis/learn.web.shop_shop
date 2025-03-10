<?php
declare(strict_types=1);

namespace learn\web\shop_shop\views;

use learn\web\shop_shop\models\View;
use learn\web\shop_shop\views\components\SignUpComponent;

class SigningView extends View {

    
    /**
     * 
     * {@inheritdoc}
     */
    protected function init(): void {
        
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function render(): View|string|false {

        $signUpViewRender = (new SignUpComponent($this->controller))->render();

        ob_start();
        ?>
            <div id="html-signing-view">
                <?=$signUpViewRender?>
            </div>
        <?php
        return ob_get_clean();
    }
}