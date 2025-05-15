<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models\securities;


interface ICheckSum {

    public function apply(): string;
    public function accepted( string $key ): bool;
}