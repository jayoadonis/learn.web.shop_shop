<?php

declare(strict_types=1);

namespace learn\web\shop_shop\controllers;

use learn\web\shop_shop\models\Controller;
use learn\web\shop_shop\models\GymStoneURL;
use learn\web\shop_shop\models\Layout;
use learn\web\shop_shop\models\View;
use learn\web\shop_shop\utils\LogType;
use learn\web\shop_shop\views\HomeView;

use learn\web\shop_shop\utils\Log;

class HomeController extends Controller
{

    // public static $count = 0;

    public function __construct(
        Layout $layout,
    ) {
        parent::__construct($layout);
        // HomeController::$count++;
        // echo strtr("HomeController instantiated <n> times\n", ["<n>" => HomeController::$count]);
    }

    /**
     * @inheritDoc Controller::render()
     */
    public function render(): View|String|false
    {

        $paramPathVerb = $this->layout->routeData->param->paramPath->get("verb");

        GymStoneURL::validateParamPathVerb( GymStoneURL::HOME, $paramPathVerb );


        if( $paramPathVerb === GymStoneURL::HOME->getParamVerb()->demoButton ) {
            $this->layout->cssManager->add("css-demo-button", "public/resources/css/misc/demo_button.css");
            $this->layout->jsManager->add("js-demo-button", "public/resources/js/misc/demo_button.js");
        }
        else {
            $homeViewRendered = (new HomeView($this))->render();
        }


        ob_start();
?>

        <div id="el-home-ctrl" class="<?= $this ?>">
            <?php if ($paramPathVerb !== GymStoneURL::HOME->getParamVerb()->demoButton): ?>
                <?= $homeViewRendered ?>
            <?php else: ?>
                <h1>UI Components Demo</h1>

                <!-- Dropdown -->
                <div class="control-group">
                    <label for="dropdown">Dropdown:</label>
                    <select id="dropdown">
                        <option value="">-- Choose an option --</option>
                        <option value="Option 1">Option 1</option>
                        <option value="Option 2">Option 2</option>
                        <option value="Option 3">Option 3</option>
                    </select>
                </div>

                <!-- Spinner -->
                <div class="control-group">
                    <label for="spinner">Spinner:</label>
                    <input type="number" id="spinner" value="0" min="0" max="100">
                </div>

                <!-- Checkboxes -->
                <div class="control-group">
                    <p>Checkboxes:</p>
                    <input type="checkbox" id="checkbox1" value="Checkbox 1">
                    <label for="checkbox1">Checkbox 1</label>

                    <input type="checkbox" id="checkbox2" value="Checkbox 2">
                    <label for="checkbox2">Checkbox 2</label>

                    <input type="checkbox" id="checkbox3" value="Checkbox 3">
                    <label for="checkbox3">Checkbox 3</label>
                </div>

                <!-- Radio Buttons (Radio Group) -->
                <div class="control-group">
                    <p>Radio Buttons:</p>
                    <input type="radio" id="radio1" name="radiogroup" value="Radio 1">
                    <label for="radio1">Radio 1</label>

                    <input type="radio" id="radio2" name="radiogroup" value="Radio 2">
                    <label for="radio2">Radio 2</label>

                    <input type="radio" id="radio3" name="radiogroup" value="Radio 3">
                    <label for="radio3">Radio 3</label>
                </div>

                <!-- Toggle -->
                <div class="control-group">
                    <p>Toggle Switch:</p>
                    <label class="switch">
                        <input type="checkbox" id="toggle">
                        <span class="slider"></span>
                    </label>
                </div>

                <!-- Image Button (Icon with Text) -->
                <div class="control-group">
                    <button id="imageButton" class="image-button">
                        <img src="" alt="Icon">
                        Click Me
                    </button>
                </div>

                <!-- Output Area -->
                <section>
                    <h2>Output</h2>
                    <div id="outputText">Interact with the controls above to see the output here.</div>
                </section>
            <?php endif; ?>
        </div>
<?php
        return ob_get_clean();
    }

    public function fromHomeCtrl(): void
    {

        // Log::log(LogType::INFO, "Home Controller...");
    }
}
