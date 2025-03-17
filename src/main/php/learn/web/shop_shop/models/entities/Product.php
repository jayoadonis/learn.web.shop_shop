<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models\entities;

use learn\web\shop_shop\models\ObjectI;
use learn\web\shop_shop\models\Status;


class Product extends Entity {

    public readonly string $name;
    public readonly float $price;

    public function __construct(
        string|null $id     = null,
        string|null $name   = null,
        float|null $price   = null
    ) {

        parent::__construct($id??"default:{$this}");
        $this->name     = $name     ?? Status::UNKNOWN;
        $this->price    = $price    ?? 0.00;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return class-string<ISessionable> 
     */
    public function getType(): string {

        return $this::class;
    }

    /**
     * 
     * {@inheritdoc}
     * @return string[]
     */
    public function __sleep(): array {

        return ["name", "price"];
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function __toString(): string {

        return strtr(
            "{cN}@{hC}[name='{name}', price={price}]",
            [
                "{cN}"      => $this::class,
                "{hC}"      => sprintf("%08x", $this->hashCode()),
                "{name}"    => $this->name,
                "{price}"   => sprintf("%.2f", $this->price)
            ]
        );
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @param ObjectI|object|array|int|float|null $obj
     */
    public function equals( mixed $obj ): bool {

        if( $obj === $this ) return true;

        if( ! ( $obj instanceof self ) ) return false;

        return $obj->name === $this->name && 
            ( abs($obj->price - $this->price) < 0.000001 ); //REM: [TODO] .|. Handle NaN and INFINITY
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function hashCode(): int {

        return parent::hashCode() + crc32(
            $this->name . $this->price
        );
    }
}