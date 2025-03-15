<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models\entities;

use learn\web\shop_shop\models\ISessionable;
use learn\web\shop_shop\models\ObjectI;

abstract class Entity extends ObjectI implements ISessionable {

    public function __construct(
        public readonly string $ID
    ) {
        
    }

    /**
     * 
     * @return string[]
     */
    public function __sleep(): array {

        return ["ID"];
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @param ObjectI|null|object|array|int|float $obj
     */
    public function equals( mixed $obj ): bool {

        if( !( $obj instanceof Entity ) ) return false;

        return parent::equals( $obj ) || 
            ( $obj->ID === $this->ID  );
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function hashCode(): int {

        return parent::hashCode() + crc32( $this->ID );
    }

}