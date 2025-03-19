<?php
declare(strict_types=1);

namespace learn\web\shop_shop\utils;

use learn\web\shop_shop\models\routes\Router;

class SimpleRouter extends Router {
    
    /**
     * @inheritDoc Router::get()
     */
    public function get(string $pathBlueprint, callable|array $ctrl ): void {

        if( !$this->add("GET", $pathBlueprint, $ctrl) )
            throw new \Exception("Cannot Be added 'path' = '{$pathBlueprint}' as GET. It already exist.");
    }
 
    /**
     * @inheritDoc Router::post()
     */
    public function post(string $pathBlueprint, callable|array $ctrl ): void {

        if( !$this->add("POST", $pathBlueprint, $ctrl) )
            throw new \Exception("Cannot Be added 'path' = '{$pathBlueprint}' as POST. It already exist.");
    }
}