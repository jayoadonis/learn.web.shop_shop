<?php
declare(strict_types=1);

require_once(__DIR__ . "/src/main/php/learn/web/shop_shop/prefetch.php");

use learn\web\shop_shop\controllers\HomeController;
use learn\web\shop_shop\models\Layout;
use learn\web\shop_shop\utils\SimpleRouter;
use learn\web\shop_shop\views\layouts\SimpleLayout;


$simpleRouter = new SimpleRouter( new SimpleLayout("prototype-i") );

$simpleRouter->get("/closure-way", function( Layout $layout ): string {

    $layout->css["css-closure-way-view"] = "/public/resources/css/closure_way_view.css";

    $paramPathID = ($layout->routeData->param?->paramPath->get("id")??"N/a");
    $paramPathVERB = ($layout->routeData->param?->paramPath->get("verb")??"N/a") ;

    $queryID = ($layout->routeData->param?->query->get("id")??"N/a");
    $queryCODE = ($layout->routeData->param?->query->get("code")??"N/a") ;

    return <<<HTML
    <div id="html-closure-way-view">
        <h1>The Closure or Callable way</h1>
        <h3>PARAM_PATHS: ID: `{$paramPathID}` ~ VERB: `{$paramPathVERB}`</h3>
        <h3>QUERIES: ID: `{$queryID}` ~ CODE: `{$queryCODE}`</h3>
    </div>
    HTML;
});

$simpleRouter->get("/", [HomeController::class]);
$simpleRouter->get("/home", [HomeController::class]);
$simpleRouter->get("/home/{id}", [HomeController::class]);
$simpleRouter->get("/home/{id}/{verb}", [HomeController::class]);


$productFC = function(Layout $layout): string {

    $paramPathID = $layout->routeData->param?->paramPath->get("id")??"N/a";
    $paramPathVERB = $layout->routeData->param?->paramPath->get("verb")??"N/a";
    

    ob_start();
    ?>
    <h1>Product</h1>
    <?php
    if( strtolower($paramPathVERB) === "edit"):
    ?>
        <h3>Edit mode</h3>
    <?php
    else:
    ?>
        <h3>Normal mode</h3>
    <?php
    endif;
    ?>


    <?php
    return ob_get_clean();
};

$simpleRouter->get("/product", $productFC );
$simpleRouter->get("/product/{id}", $productFC );
$simpleRouter->get("/product/{id}/{verb}", $productFC );

$simpleRouter->dispatch();






//REM: Get the query string from the URL
$queryString = parse_url($_SERVER["REQUEST_URI"], PHP_URL_QUERY);


//REM: Parse the query string into an associative array
if (is_string($queryString)) {

    echo "<pre>";
    echo ">>> " . htmlspecialchars($queryString, ENT_QUOTES, 'UTF-8');
    echo "</pre>";

    parse_str($queryString, $queryParams);


    $sanitizedAssoc = [];
    //REM: Output the associative array with escaped values
    echo "<pre>";
    //REM: Use htmlspecialchars on each array value to prevent XSS
    foreach ($queryParams as $key => $value) {
        $sanitizedAssoc[htmlspecialchars($key, ENT_QUOTES, 'UTF-8')] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    echo "</pre>";

    // echo "<<< " . html_entity_decode($x) . "</br>";

    echo "<pre>";
    $y = json_encode($sanitizedAssoc, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    echo "<><><> " . $y . "</br>";
    echo "</pre>";
    
    echo "<pre>";
    $decodedArray = json_decode($y, true);
    print_r($decodedArray);
    echo "</pre>";

}


?>

