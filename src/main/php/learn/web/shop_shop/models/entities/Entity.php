<?php

declare(strict_types=1);

namespace learn\web\shop_shop\models\entities;

use learn\web\shop_shop\models\ISessionable;
use learn\web\shop_shop\models\ObjectI;

abstract class Entity extends ObjectI implements ISessionable
{
    /**
     * 
     * Simple Quicky Check Sum
     * 
     * @note **[NOTE]** .|. Don't ever pre-initialized it anywhere. Except at `Entity::class:__sleep()`
     * @note **[NOTE]** .|. Don't use it anywhere. Except at `Entity::class:__wakeup()`
     */
    protected readonly string $checkIt; 

    public function __construct(
        public readonly string $ID
    ) {
    }

    /**
     * 
     * @return string[]
     */
    public function __sleep(): array
    {
        if( isset($this->checkIt) )
            throw new \Exception("Check Sum improper pre-initialization.");

        $this->checkIt = \md5( $this->__toString() );

        return ["ID", "checkIt"];
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function __wakeup(): void
    {

        if( !isset($this->checkIt) || $this->checkIt !== \md5( $this->__toString() ) )
            throw new \Exception("Data Integrity check failed.");
    }

    /**
     * 
     * {@inheritdoc}
     * 
     */
    public function __toString(): string
    {

        return strtr(
            "{cN}[id='{id}']",
            [
                "{cN}"  => sprintf("%s@%08x", $this::class, $this->hashCode()),
                "{id}"  => $this->ID
            ]
        );
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @param ObjectI|null|object|array|int|float $obj
     */
    public function equals(mixed $obj): bool
    {

        if (!($obj instanceof Entity)) return false;

        return parent::equals($obj) ||
            ($obj->ID === $this->ID);
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function hashCode(): int
    {

        return crc32($this->ID);
    }
}
