<?php

declare(strict_types=1);

namespace learn\web\shop_shop\controllers;

use learn\web\shop_shop\models\Controller;
use learn\web\shop_shop\models\entities\User;
use learn\web\shop_shop\models\GymStoneURL;
use learn\web\shop_shop\models\Layout;
use learn\web\shop_shop\models\Status;
use learn\web\shop_shop\models\View;
use learn\web\shop_shop\utils\LogType;
use learn\web\shop_shop\views\HomeView;

use learn\web\shop_shop\utils\Log;
use learn\web\shop_shop\views\components\misc\DemoButton;
use learn\web\shop_shop\utils\Option;
use learn\web\shop_shop\models\routes\ParamPath;

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

        /**
         * 
         * @var object{id:Option<string>,verb:Option<string>}
         */
        $paramPath = $this->layout->routeData->param->paramPath;

        /**
         * 
         * @var Option<string>
         */
        $paramPathVerbOption = $paramPath->verb;

        /**
         * 
         * @var string
         */
        $paramPathVerb = $paramPathVerbOption->getOrElse(Status::UNKNOWN->value);

        $paramPathId = $paramPath->id->getOrElse(Status::UNKNOWN->value);
        $paramPathSurpise = $paramPath->surprise->getOrElse(Status::UNKNOWN->value);

        $isDemoButtonURL = ($paramPathVerb === GymStoneURL::HOME->getParamVerb()::DEMO_BUTTON->value );

        
        ob_start();
?>

        <div id="el-home-ctrl" class="<?= $this ?>">
            <?php if ( ! $isDemoButtonURL ): ?>
                <?= (new HomeView($this))->render() ?>
            <?php else: ?>
                <?= (new DemoButton($this))->render() ?>
            <?php endif; ?>
            <?= $paramPathSurpise ?>
        </div>
<?php
        return ob_get_clean();
    }

    public function fromHomeCtrl(): void
    {

        // Log::log(LogType::INFO, "Home Controller...");
    }
}
