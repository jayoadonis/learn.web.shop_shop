<?php
declare(strict_types=1);

namespace learn\web\shop_shop\views\components;

use learn\web\shop_shop\models\View;
use learn\web\shop_shop\models\Controller;
use learn\web\shop_shop\utils\BaseDir;
use learn\web\shop_shop\utils\Log;
use learn\web\shop_shop\utils\LogType;

/**
 * 
 * @extends View<Controller>
 */
class SignUpComponent extends View {

    
    
    /**
     * 
     * @inheritdoc
     */
    public function init(): void {

        $this->controller->layout->title .= " ~ " . preg_replace("/^(.*)\\\\/", "", $this::class );

        $this->controller->layout->cssManager->add(
            "css-sign-up-component", BaseDir::getResource("/public/resources/css/views/components/sign_up_component.css")
        );

        $this->controller->layout->jsManager->add(
            "js-store-api", BaseDir::getResource("/public/resources/js/utils/apis/users/store_api.js")
        );
    }

    /**
     * 
     * @inheritdoc
     */
    public function render(): View|string|false {

        Log::log(LogType::INFO, "{$this}");

        ob_start();
        ?>
            <div id="html-sign-up-component" >
                <form data-form-sign-up>
                    <div class="el-full-name">
                        <input name="first_name" type="text" placeholder="First Name"/>
                        <input name="middle_name" type="text" placeholder="Middle Name"/>
                        <input name="last_name" type="text" placeholder="Last Name"/>
                    </div>
                    <div class="el-general-info">
                        <select name="gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Secret">Secret</option>
                        </select>
                        <input name="civil_status" type="text" placeholder="Civil Status"/>
                    </div>

                    <button id="html-btn-sign-up" 
                    type="button" 
                    data-btn-sign-up 
                    data-store
                    class="el-btn-sign-up">
                        Sign Up
                    </button>
                </form>
            </div>
        <?php

        return ob_get_clean();
    }
}