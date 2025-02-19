<?php
declare(strict_types=1);

namespace learn\web\shop_shop\utils;

use learn\web\shop_shop\models\routes\Router;

class SimpleRouter extends Router {
    
    /**
     * @inheritDoc Router::get()
     */
    public function get(string $path, callable|array $ctrl ): void {

        if( !$this->add("GET", $path, $ctrl) )
            throw new \Exception("Cannot Be added 'path' = '{$path}' as GET.");
    }
 
    /**
     * @inheritDoc Router::post()
     */
    public function post(string $path, callable|array $ctrl ): void {

        if( !$this->add("POST", $path, $ctrl) )
            throw new \Exception("Cannot Be added 'path' = '{$path}' as POST.");
    }
}