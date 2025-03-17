<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models\routes;

use learn\web\shop_shop\models\ObjectI;
use learn\web\shop_shop\models\Layout;
use learn\web\shop_shop\models\Status;

class RouteData extends ObjectI {
    
    /**
     * 
     * @param string $METHOD
     * @param string $PATH
     * @param Param|null $param
     * @param array<string>|callable(Layout):string|\Closure(Layout):string $CONTROLLER
     */
    public function __construct(
        public readonly string $METHOD,
        public readonly string $PATH_BLUEPRINT,
        public ?string $path,
        public ?Param $param,
        public readonly mixed $CONTROLLER
    ) {

    }

    /**
     * 
     * {@inheritdoc}
     */
    public function __toString(): string {

        return sprintf(
            "%s[PATH_BLUEPRINT='%s', path='%s']",
            parent::__toString(),
            $this->PATH_BLUEPRINT,
            $this->path??Status::UNKNOWN->toString()
        );
    }

}