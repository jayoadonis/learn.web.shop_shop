<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;


interface IRenderer {
    
    public function init(): void;

    public function render(): View|string|false;
}