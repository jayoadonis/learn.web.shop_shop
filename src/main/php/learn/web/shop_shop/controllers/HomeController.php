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
use learn\web\shop_shop\views\components\misc\DemoButton;

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
     * 
     * {@inheritdoc}
     */
    public function init(): void {

    }

    /**
     * @inheritDoc Controller::render()
     */
    public function render(): View|String|false
    {

        $paramPathVerb = $this->layout->routeData->param->paramPath->get("verb");

        $isDemoButtonURL = ($paramPathVerb === GymStoneURL::HOME->getParamVerb()->demoButton);

        ob_start();
?>

        <div id="el-home-ctrl" class="<?= $this ?>">
            <?php if ( ! $isDemoButtonURL ): ?>
                <?= (new HomeView($this))->render() ?>
            <?php else: ?>
                <?= (new DemoButton($this))->render() ?>
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
