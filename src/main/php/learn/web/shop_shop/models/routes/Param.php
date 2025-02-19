<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models\routes;

use learn\web\shop_shop\models\ObjectI;


class Param extends ObjectI {

    
    public function __construct(
        public ParamPath $paramPath,
        public Query $query
    ) {

    }

}