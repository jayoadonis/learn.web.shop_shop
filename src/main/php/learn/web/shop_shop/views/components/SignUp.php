<?php
declare(strict_types=1);

namespace learn\web\shop_shop\views\components;

use learn\web\shop_shop\models\View;
use learn\web\shop_shop\models\Controller;

/**
 * 
 * @extends View<Controller>
 */
class SignUp extends View {

    /**
     * 
     * @inheritdoc
     */
    public function render(): View|string|false {

        ob_start();
        ?>
            <div id="html-sign-up-component" style="display: flex; background: lime;">
                <form style="display: flex; flex-direction: column; margin: 0 auto;">
                    <div class="full-name">
                        <input name="first_name" type="text" placeholder="First Name"/>
                        <input name="middle_name" type="text" placeholder="Middle Name"/>
                        <input name="last_name" type="text" placeholder="Last Name"/>
                    </div>
                    <div class="">
                        <select name="gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Secret">Secret</option>
                        </select>
                        <input name="civil_status" type="text" placeholder="Civil Status"/>
                    </div>

                    <button type="button">Sign Up</button>
                </form>
            </div>
        <?php

        return ob_get_clean();
    }
}