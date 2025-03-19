<?php

declare(strict_types=1);

require_once(__DIR__ . "/src/main/php/learn/web/shop_shop/prefetch.php");

use learn\web\shop_shop\controllers\HomeController;
use learn\web\shop_shop\controllers\SigningController;
use learn\web\shop_shop\misc\music_app\controllers\MusicController;
use learn\web\shop_shop\models\GymStoneURL;
use learn\web\shop_shop\models\Entity;
use learn\web\shop_shop\models\Layout;
use learn\web\shop_shop\models\entities\User;
use learn\web\shop_shop\utils\BaseDir;
use learn\web\shop_shop\utils\Session;
use learn\web\shop_shop\utils\SimpleRouter;
use learn\web\shop_shop\views\layouts\SimpleLayout;
use learn\web\shop_shop\misc\music_app\views\layouts\SimpleMusicLayout;
use learn\web\shop_shop\models\dbs\DbConfig;
use learn\web\shop_shop\models\ProductParamPathVerb;
use learn\web\shop_shop\models\Status;
use learn\web\shop_shop\utils\Config;
use learn\web\shop_shop\utils\Log;
use learn\web\shop_shop\utils\LogType;
use learn\web\shop_shop\utils\Option;

// Session::set( new User( email: "email@io.com") );

// $x = Session::get(User::class);

// print_r( $x->getEmail() . "<br>");
// echo( $x->password->value . "<br>");
// echo "<pre>";
// var_dump($x);
// echo "</pre>";

// Session::setWithExplicitId("user_1", new User( "102", "user_123", "user_122223@email.io"));

// print_r( Session::get( "user_1" )?->getEmail() );

// Session::clearAll();

// echo filter_var( getenv("IS_ACTIVE_LOG"), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === null;

$simpleRouter = new SimpleRouter(new SimpleLayout(__CONFIGS["general"]["app_name"] ?: "prototype-i"));


$simpleRouter->get("/",                                    [HomeController::class]);
$simpleRouter->get(GymStoneURL::HOME->get(),               [HomeController::class]);
$simpleRouter->get(GymStoneURL::HOME->get("{id}/"),        [HomeController::class]);
$simpleRouter->get(GymStoneURL::HOME->get("{id}/{verb}"),  [HomeController::class]);

$simpleRouter->get("/music-app",                           [MusicController::class, [], SimpleMusicLayout::class]);
$simpleRouter->get("/music-app/{what}",                    [MusicController::class, [], SimpleMusicLayout::class]);

// $simpleRouter->post("/signing/{verb}", [SigningAPIController::class]);

$simpleRouter->get("/closure-way", function (Layout $layout): string {

    $layout->cssManager->add("css-closure-way-view", BaseDir::getResource("/public/resources/css/views/closure_way_view.css"));

    $paramPathID = $layout->routeData->param?->paramPath->id->getOrElse("<default>");
    $paramPathVERB = $layout->routeData->param?->paramPath->verb->getOrElse("<script>alert('oh no')</script>");

    $queryID = ($layout->routeData->param?->query->get("id")?? "N/a");
    $queryCITY = ($layout->routeData->param?->query->get("city")?? "N/a");

    return <<<HTML
    <div id="html-closure-way-view">
        <h1>The Closure or Callable way</h1>
        <h3>PARAM_PATHS: ID: `{$paramPathID}` ~ VERB: `{$paramPathVERB}`</h3>
        <h3>QUERIES: ID: `{$queryID}` ~ CODE: `{$queryCITY}`</h3>
    </div>
    HTML;
});

$productFC = function (Layout $layout): string {

    $layout->cssManager->add("css-product-fc", BaseDir::getResource("/public/resources/css/views/product_view.css"));

    $paramPathIdOption      = $layout->routeData->param?->paramPath->id;
    $paramPathVerbOption    = $layout->routeData->param?->paramPath->verbz;
    
    $paramPathId            = $paramPathIdOption->getOrElse(Status::UNKNOWN->value);
    $paramPathVerb          = $paramPathVerbOption->getOrElse(Status::UNKNOWN->value);

    ob_start();
?>
    <div id="el-id-product-view">

        <h1>Product</h1>

        <?= $paramPathVerb ?>

        <?php switch ($paramPathVerb) {
            case 'edit':
                ob_start();
        ?>
                <h3 class="el-lbl-edit">Edit mode</h3>
                <h1>verb: <?= $paramPathVerb ?></h1>
                <h1>id: <?= $paramPathId ?></h1>
            <?php
                echo ob_get_clean();
                break;

            case GymStoneURL::PRODUCT->getParamVerb()::CREATE->value:
                ob_start();
            ?>
                <h3 class="el-lbl-normal">Create Mode</h3>
        <?php
                echo ob_get_clean();
                break;

            case Status::UNKNOWN->value:
                ob_start();
            ?>
                <h3 class="el-lbl-normal">Normal Mode</h3>
                <h1>verb: <?= $paramPathVerb ?></h1>
                <h1>id: <?= $paramPathId ?></h1>
        <?php
                echo ob_get_clean();
                break;

            default:
                Log::log(LogType::WARN, "[" . 300 . "] Redirecting '/400', {$layout->__toString()}");
                header("location: /404");
                exit();
        } ?>

    </div>
<?php

    Log::log(LogType::INFO, $layout->__toString());
    return ob_get_clean();
};

$simpleRouter->get("/product", $productFC);
$simpleRouter->get("/product/{id}", $productFC);
$simpleRouter->get("/product/{id}/{verb}", $productFC);

$simpleRouter->get("/signing", [SigningController::class]);


$simpleRouter->dispatch();


//REM: Get the query string from the URL
$queryString = parse_url($_SERVER["REQUEST_URI"], PHP_URL_QUERY);

//REM: Parse the query string into an associative array
if (is_string($queryString)) {
    echo ">>>0 " . $queryString . "<br>";

    echo "<pre>";
    echo ">>>1 " . htmlentities($queryString, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    echo "</pre>";

    parse_str($queryString, $queryParams);


    $sanitizedAssoc = [];
    //REM: Output the associative array with escaped values
    echo "<pre>";
    //REM: Use htmlspecialchars on each array value to prevent XSS
    foreach ($queryParams as $key => $value) {
        echo ">><> " . ( $sanitizedAssoc[htmlspecialchars($key, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')] = htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ) . "<br>";
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

// print_r("<pre>");
// var_dump(__CONFIGS);
// print_r("</pre>");

echo Config::DATABASE->data()->toHTMLString();

// echo "<pre>";
// var_dump( $_SERVER );
// echo "</pre>";



// /**
//  * 
//  * @var Option<string>
//  */
// $option = Option::some("okasdfasd");
// $option1 = Option::some("okasdfasd");

// echo "<br>value: '" . $option->unwrap() . "'<br>";
// echo "<br>value: '" . $option1->unwrap() . "'<br>";
// echo "<br>value: '" . $option->equals($option1) . "'<br>";
?>