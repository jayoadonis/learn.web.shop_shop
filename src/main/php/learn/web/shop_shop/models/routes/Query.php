<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models\routes;

use learn\web\shop_shop\models\ObjectI;


class Query extends ObjectI {

    /**
     * @param array<string,string> $datas
     */
    public function __construct( 
        public array $datas
    ) { }

    public function insert( string $key, string $data ): void {

        $this->datas[$key] = $data;
    }
    /**
     * 
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