<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models\routes;

use learn\web\shop_shop\models\ObjectI;
use learn\web\shop_shop\models\Layout;

class RouteData extends ObjectI {
    
    /**
     * 
     * @param string $METHOD
     * @param string $PATH
     * @param Param|null $param
     * @param string[]|callable(Layout):string|\Closure(Layout):string $CONTROLLER
     */
    public function __construct(
        public readonly string $METHOD,
        public readonly string $PATH,
        public ?Param $param,
        public readonly mixed $CONTROLLER
    ) {

    }

}