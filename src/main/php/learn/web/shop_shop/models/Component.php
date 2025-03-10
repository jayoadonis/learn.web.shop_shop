<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;

use learn\web\shop_shop\models\View;
use learn\web\shop_shop\models\Controller;

/**
 * 
 * @extends View<Controller>
 */
abstract class Component extends View {

    public function __construct(
        Controller $ctrl
    ) {
        parent::__construct($ctrl);
    }
}