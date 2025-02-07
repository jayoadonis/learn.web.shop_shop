<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;

/**
 * 
 * @template T of Controller
 */
abstract class View extends ObjectI implements IRenderer {
    
    /**
     * 
     * @param T $controller
     */
    public function __construct(
        public mixed $controller,
    ) {

    }

    public abstract function render(): View|string|false;
}