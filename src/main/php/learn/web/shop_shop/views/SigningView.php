<?php
declare(strict_types=1);

namespace learn\web\shop_shop\views;

use learn\web\shop_shop\models\View;
use learn\web\shop_shop\views\components\SignUp;

class SigningView extends View {


    /**
     * 
     * {@inheritdoc}
     */
    public function render(): View|string|false {

        $signUpViewRender = (new SignUp($this->controller))->render();

        ob_start();
        ?>
            <div id="html-signing-view" style="">
                <?=$signUpViewRender?>
                <?
            </div>
        <?php
        return ob_get_clean();
    }
}