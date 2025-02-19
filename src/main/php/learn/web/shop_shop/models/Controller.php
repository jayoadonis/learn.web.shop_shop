<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;

use learn\web\shop_shop\models\routes\RouteData;

abstract class Controller extends ObjectI implements IRenderer {

    public function __construct(
        public Layout $layout
    ) {
    }

}