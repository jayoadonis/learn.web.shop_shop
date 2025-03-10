<?php
declare(strict_types=1);

require_once(__DIR__ . "/src/main/php/learn/web/shop_shop/prefetch.php");



use learn\web\shop_shop\controllers\HomeController;
use learn\web\shop_shop\controllers\SigningController;
use learn\web\shop_shop\misc\music_app\controllers\MusicController;
use learn\web\shop_shop\models\GymStoneURL;
use learn\web\shop_shop\models\Entity;
use learn\web\shop_shop\models\Layout;
use learn\web\shop_shop\models\User;
use learn\web\shop_shop\utils\BaseDir;
use learn\web\shop_shop\utils\Session;
use learn\web\shop_shop\utils\SimpleRouter;
use learn\web\shop_shop\views\layouts\SimpleLayout;
use learn\web\shop_shop\misc\music_app\views\layouts\SimpleMusicLayout;

// Session::set( new User( "101", "user_123", "user_123@email.io") );

// print_r( Session::get(User::class)->getEmail() );

// Session::setWithExplicitId("user_1", new User( "102", "user_123", "user_122223@email.io"));

// print_r( Session::get( "user_1" )?->getEmail() );

// Session::clearAll();

$simpleRouter = new SimpleRouter( new SimpleLayout("prototype-i") );


$simpleRouter->get( "/",                                    [HomeController::class]);
$simpleRouter->get( GymStoneURL::HOME->get(),               [HomeController::class]);
$simpleRouter->get( GymStoneURL::HOME->get("{id}"),         [HomeController::class]);
$simpleRouter->get( GymStoneURL::HOME->get("{id}/{verb}"),  [HomeController::class]);

$simpleRouter->get("/music-app",                            [MusicController::class, SimpleMusicLayout::class]);


$simpleRouter->get("/closure-way", function( Layout $layout ): string {

    $layout->cssManager->add("css-closure-way-view", BaseDir::getResource("/public/resources/css/closure_way_view.css"));

    $paramPathID = ($layout->routeData->param?->paramPath->get("id")??"N/a");
    $paramPathVERB = ($layout->routeData->param?->paramPath->get("verb")??"N/a") ;

    $queryID = ($layout->routeData->param?->query->get("id")??"N/a");
    $queryCITY = ($layout->routeData->param?->query->get("city")??"N/a") ;

    return <<<HTML
    <div id="html-closure-way-view">
        <h1>The Closure or Callable way</h1>
        <h3>PARAM_PATHS: ID: `{$paramPathID}` ~ VERB: `{$paramPathVERB}`</h3>
        <h3>QUERIES: ID: `{$queryID}` ~ CODE: `{$queryCITY}`</h3>
    </div>
    HTML;
});


$productFC = function(Layout $layout): string {

    $layout->cssManager->add("css-product-fc", BaseDir::getResource("/public/resources/css/view/product_view.css"));

    $paramPathID = $layout->routeData->param?->paramPath->get("id")??"N/a";
    $paramPathVERB = $layout->routeData->param?->paramPath->get("verb")??"N/a";
    

    ob_start();
    ?>
    <h1>Product</h1>
    <?php
    if( strtolower($paramPathVERB) === "edit"):
    ?>
        <h3 id="el-lbl-edit">Edit mode</h3>
        <h1>verb: <?=$paramPathVERB?></h1>
        <h1>id: <?=$paramPathID?></h1>
    <?php
    else:
    ?>
        <h3 id="el-lbl-normal">Normal mode</h3>
        <h1>verb: <?=$paramPathVERB?></h1>
        <h1>id: <?=$paramPathID?></h1>
    <?php
    endif;
    ?>


    <?php
    return ob_get_clean();
};

$simpleRouter->get("/product", $productFC );
$simpleRouter->get("/product/{id}", $productFC );
$simpleRouter->get("/product/{id}/{verb}", $productFC );

$simpleRouter->get("/signing", [SigningController::class]);


$simpleRouter->dispatch();


//REM: Get the query string from the URL
$queryString = parse_url($_SERVER["REQUEST_URI"], PHP_URL_QUERY);

//REM: Parse the query string into an associative array
if (is_string($queryString)) {

    echo "<pre>";
    echo ">>>1 " . htmlspecialchars($queryString, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8');
    echo "</pre>";

    parse_str($queryString, $queryParams);


    $sanitizedAssoc = [];
    //REM: Output the associative array with escaped values
    echo "<pre>";
    //REM: Use htmlspecialchars on each array value to prevent XSS
    foreach ($queryParams as $key => $value) {
        print ">><> " . $sanitizedAssoc[htmlspecialchars($key, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8')] = htmlspecialchars($value, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8') . "<br>";
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
    
    echo "<pre>";
    $decodedArray = json_decode($y);
    print_r($decodedArray);
    echo "</pre>";

    echo "done...";
}



?>

