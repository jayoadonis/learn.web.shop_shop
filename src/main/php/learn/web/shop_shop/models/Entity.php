<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;


abstract class Entity extends ObjectI implements ISessionable {

    /**
     * @var class-string<ISessionable> $TYPE
     */
    public readonly string $TYPE;

    public function __construct(
        public readonly string $ID
    ) {
        $this->TYPE = $this::class;
    }

    /**
     * 
     * @return string[]
     */
    public function __sleep(): array {

        return ["ID", "TYPE"];
    }

}