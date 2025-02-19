<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models\routes;

use learn\web\shop_shop\models\ObjectI;

class ParamPath extends ObjectI {

    /**
     * @param array<string,string> $datas
     */
    public function __construct(
        private array $datas
    ) { }

    public function insert( string $key, string $value ): void {

        $this->datas[$key] = $value;
    }

    /**
     * @param array<string,string> $datas
     */
    public function set( array $datas ): void {

        $this->datas = $datas;
    }

    /**
     * @param string $key
     * @return string|null 
     */
    public function get( string $key ): ?string {

        return $this->datas[$key] ?? null;
    }

}