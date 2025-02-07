<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;

abstract class Layout extends ObjectI implements IRenderer {

    public string $title;

    public IRenderer|string|false $outlet = false;
    /**
     * @var array<string,string> $css
     */
    public array $css = [];

    public function __construct( 
        string $title
    ) {
        $this->title = $title;
    }

    public function render(): View|string|false {

        $outlet = $this->outlet;

        if( $outlet instanceof IRenderer )
            return $outlet->render();

        return $outlet;
    }
}