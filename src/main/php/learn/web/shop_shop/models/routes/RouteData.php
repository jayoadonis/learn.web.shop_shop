<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models\routes;

use learn\web\shop_shop\models\ObjectI;

class RouteData extends ObjectI {
    
    /**
     * 
     * @param string $METHOD
     * @param string $PATH
     * @param array<string,mixed> $PARAMS
     * @param callable|array<string> $CONTROLLER
     */
    public function __construct(
        public readonly string $METHOD,
        public readonly string $PATH,
        public readonly array $PARAMS,
        public readonly mixed $CONTROLLER
    ) {

    }

}