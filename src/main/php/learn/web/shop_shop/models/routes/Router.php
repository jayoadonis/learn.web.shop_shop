<?php

declare(strict_types=1);

namespace learn\web\shop_shop\models\routes;

use learn\web\shop_shop\models\Controller;
use learn\web\shop_shop\models\Layout;
use learn\web\shop_shop\models\ObjectI;
use learn\web\shop_shop\models\routes\RouteData;
use learn\web\shop_shop\utils\BaseDir;
use learn\web\shop_shop\utils\Log;
use learn\web\shop_shop\utils\LogType;
use ReflectionNamedType;

abstract class Router extends ObjectI
{

    /**
     * @var array<string,array<string,RouteData>> $ROUTES
     */
    protected static array $ROUTES;

    public function __construct(
        public Layout $layout
    ) {}

    /**
     * @param callable|array<string> $controller
     */
    protected function add(
        string $method,
        string $pathBlueprint,
        callable|array $controller
    ): bool {

        $param = new Param(
            new ParamPath([]),
            new Query([])
        );

        //REM: [TODO] .|. Only works with class controller...
        if( is_array( $controller ) ) {

            if( is_array( $controller[1]??null ) ) 
                $param->paramPath->addValidParamPathKey( $controller[1] );
            
            // if( is_array( $controller[2]??null ) ) 
            //     $param->query->addValidQueryKey( $controller[2] );
        }

        if (!isset(self::$ROUTES[$method][$pathBlueprint])) {
            self::$ROUTES[$method][$pathBlueprint] = new RouteData(
                $method,
                $pathBlueprint,
                null,
                $param,
                $controller
            );

            return true;
        }

        return false;
    }

    public function dispatch(): void
    {

        $routeData = $this->reloadRouterData();  //REM: [TODO]

        // $parsedURL = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

        //REM: Cannot found current URL in related to the registered list of URLs
        // if( !$parsedURL 
        //     || !isset(self::$ROUTES[ $_SERVER["REQUEST_METHOD"] ][ $parsedURL = ("/" . trim($parsedURL, "/") ) ] )
        // ) {

        if (!$routeData) {

            try {
                $this->get("/404", function (Layout $layout): string {

                    $layout->cssManager->add("css-page-not-found-view", BaseDir::getResource("/public/resources/css/views/page_not_found_view.css"));

                    return <<<HTML
                    <div id="html-page-not-found-view">
                        <h1>404: Page Not Found...</h1>
                    </div>
                    HTML;
                });
            } catch (\Exception $ex) {
                error_log("::: " . $ex->getMessage(), E_USER_WARNING);
            }

            http_response_code(404);

            $parsedURL = "/404";

            $routeData = $this->reloadRouterData(null, $parsedURL);  //REM: [TODO]
        }


        $controller = $routeData?->CONTROLLER;

        //REM: Closure, function, lambda or/and callable that return a string type
        if ( /*is_callable($controller) &&*/($controller instanceof \Closure)) {

            $rFunc = new \ReflectionFunction($controller);
            if (
                ($returnType = $rFunc->getReturnType())
                && $returnType instanceof \ReflectionNamedType
                && $returnType->getName() === "string"
            ) {

                $params = $rFunc->getParameters();

                if( count($params) === 1 
                    && ($paramType = $params[0]->getType()) instanceof \ReflectionNamedType
                    && $paramType->getName() === Layout::class
                ) {

                    $this->layout->routeData = $routeData;
                    // $this->layout->setOutlet(call_user_func($controller, $this->layout));
                    $this->layout->setOutlet( $controller( $this->layout ) );
    
                    echo $this->layout->render();
                    return;
                }
            }

            throw new \Exception(
                "Invalid Callable or Closure signature, it should only return a 'string' type and a param type of '" 
                . Layout::class 
                . "'; RouteData: '" . $routeData->PATH_BLUEPRINT . "'"
            );
        }
        //REM: (canonnical name) A Subclass of models\Controller.php
        elseif (is_array($controller) && ($arrayControllerCount = count($controller)) > 0) {

            if ($arrayControllerCount <= 2 ) {

                /**
                 * 
                 * @var class-string<Controller> $class
                 */
                [$class] = $controller;

                if( $arrayControllerCount == 2 ) {
                    /**
                     * 
                     * @var class-string<Controller> $class
                     * @var class-string<Layout> $layoutClass
                     */
                    [$class, $layoutClass] = $controller;

                    if( class_exists($layoutClass) && is_subclass_of($layoutClass, Layout::class) ) {

                        $this->layout = new $layoutClass($this->layout->title);

                    } else {

                        //REM: i.e. [HomeController::class, "index"]
                        /**
                         * @var class-string<controller> $class
                         * @var string $memberFunction
                         */
                        [$class, $memberFunction] = $controller;
                        //REM: [TODO] .|. Not yet supported...
                        throw new \Exception("Not yet supported 'compound' reflection?");
                    }
                }



                if (class_exists($class) && is_subclass_of($class, Controller::class)) {

                    // Log::log(
                    //     LogType::INFO, "Router dispatch(V)V "
                    // );

                    //REM: Controller
                    $ctrlObj = new $class($this->layout);

                    // $routeData = $this->reloadRouterData(); //REM: [TODO]

                    // if( $ctrlObj instanceof Controller )
                    $this->layout->setOutlet($ctrlObj);
                    $this->layout->setRouteData($routeData);

                    echo $this->layout->render();

                    return;
                }
            }
        }

        throw new \Exception("Invalid controller type, cannot dispatch.");
    }

     //REM: [TODO]
    private function reloadRouterData(
        ?string $requestMethod = null,
        ?string $requestURLPath = null
    ): ?RouteData {

        $requestMethod = strtoupper($requestMethod ?? $_SERVER["REQUEST_METHOD"] ?? "GET");
        $requestURLPath = "/" . trim(parse_url($requestURLPath ?? $_SERVER["REQUEST_URI"] ?? "/404", PHP_URL_PATH), "/");

        foreach (self::$ROUTES[$requestMethod] ?? [] as $pathBlueprint => $routeData) {

            $pathPattern = preg_replace("/\{(\w+)\}/", "([^/]+)", $pathBlueprint);
            $pathPattern = "#^$pathPattern$#";

            $paramPathValues = [];

            if (preg_match($pathPattern, $requestURLPath, $paramPathValues)) {

                // echo "<pre>";
                // print_r($paramPathValues);
                // echo "</pre>";


                array_shift($paramPathValues);

                $paramPathKeys = [];

                preg_match_all("/\{(\w+)\}/", $pathBlueprint, $paramPathKeys);

                // echo "<pre>";
                // print_r($paramPathKeys);
                // echo "</pre>";

                /**
                 * @psalm-suppress UnnecessaryVarAnnotation
                 * @var array<string,string> $paramPaths
                 */
                $paramPaths = array_combine(
                    $paramPathKeys[1],
                    $paramPathValues
                ) ?: [];

                $sanitizedRequestParamPaths = [];

                foreach ($paramPaths as $key => $value) {
                    $sanitizedRequestParamPaths[htmlspecialchars($key, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')]
                        = htmlspecialchars( $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                }

                $routeData->param?->paramPath->set($sanitizedRequestParamPaths);


                $strQuery = parse_url($_SERVER["REQUEST_URI"] ?? "?error_code=123", PHP_URL_QUERY);

                if (is_string($strQuery)) {

                    parse_str($strQuery, $requestQueries);

                    $sanitizedRequestQueries = [];

                    foreach ($requestQueries as $key => $value) {
                        $sanitizedRequestQueries[htmlspecialchars($key, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')]
                            = htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                    }

                    $routeData->param?->query->set($sanitizedRequestQueries);
                }

                $routeData->path = $requestURLPath;

                return $routeData;
            }
        }

        return null;
    }

    /**
     * 
     * @param callable|array<string> $ctrl
     */
    public abstract function get(string $pathBlueprint, callable|array $ctrl): void;

    /**
     * 
     * @param callable|array<string> $ctrl
     */
    public abstract function post(string $pathBlueprint, callable|array $ctrl): void;
}
