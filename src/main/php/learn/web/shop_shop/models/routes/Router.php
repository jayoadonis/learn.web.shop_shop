<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models\routes;

use learn\web\shop_shop\models\Controller;
use learn\web\shop_shop\models\Layout;
use learn\web\shop_shop\models\ObjectI;
use learn\web\shop_shop\models\routes\RouteData;


abstract class Router extends ObjectI {

    /**
     * @var array<string,array<string,RouteData> $ROUTES
     */
    public readonly array $ROUTES;

    public function __construct(
        public readonly Layout $layout
    ) {}

    /**
     * @param callable|array<string> $controller
     */
    protected function add(
        string $method,
        string $path,
        callable|array $controller
    ): bool {
        
        if( !isset( $this->ROUTES[$method][$path]) ) {
            $this->ROUTES[$method][$path] = new RouteData(
                $method,
                $path,
                [],
                $controller
            );

            return true;
        }

        return false;
    }
    
    protected function dispatch(): void {

        $routes = $this->ROUTES
            [ $_SERVER["REQUEST_METHOD"] ]
            [ parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) ];

        $controller = $routes->CONTROLLER;

        if( is_callable($controller) ) {
            echo call_user_func($controller);
            return;
        }
        elseif( is_array( $controller ) && ($arrayControllerCount = count($controller)) > 0 ) {

            if( $arrayControllerCount === 1 ) {

                [$class] = $controller;

                if( class_exists($class) && is_subclass_of($class, Controller::class) ) {

                    $ctrlObj = new $class($this->layout);

                    // if( $ctrlObj instanceof Controller )
                    $this->layout->outlet = $ctrlObj;

                    echo $this->layout->render();
                    return;
                }

            }
            else {

                [$class, $index] = $controller;

            }
        }

        throw new \Exception("Invalid controller type, cannot dispatch.");
    }
}