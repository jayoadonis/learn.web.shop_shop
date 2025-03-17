<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;

use learn\web\shop_shop\models\routes\RouteData;

abstract class Layout extends ObjectI implements IRenderer {

    public string $title;

    public const ID = "debug:learn\web\shop_shop";

    //REM: [TODO] .|. Encapsulate this properly.
    protected IRenderer|string|false $outlet = false;

    //REM: [TODO] .|. Encapsulate this properly.
    /**
     * @var array<string,string> $css
     */
    // public array $css = [];
    
    public CSSManagerI $cssManager;

    // public array $js = [];
    public JSManager $jsManager;
    
    //REM: [TODO] .|. Encapsulate this properly.
    public ?RouteData $routeData;

    public function __construct( 
        string $title = self::ID
    ) {
        $this->title = $title;
        $this->cssManager = new CSSManagerI();
        $this->jsManager = new JSManager();

        $this->init();
    }

    public function setRouteData( ?RouteData $routeData ): void {

        $this->routeData = $routeData;
    }

    public function setOutlet( IRenderer|string|false $outlet ) {

        $this->outlet = $outlet;
    }

    public function render(): View|string|false {

        $outlet = $this->outlet;

        if( $outlet instanceof IRenderer )
            return $outlet->render();

        return $outlet;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function __toString(): string {

        return sprintf(
            "%s[routeData='%s']",
            parent::__toString(),
            $this->routeData->__toString()
        );
    }
}