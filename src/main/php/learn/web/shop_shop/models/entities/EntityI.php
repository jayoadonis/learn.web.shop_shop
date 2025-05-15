<?php
declare(strict_types=1);

namespace learn\web\shop_shop\modles\entities;

use learn\web\shop_shop\models\ISessionableI;
use learn\web\shop_shop\models\ObjectI;
use learn\web\shop_shop\models\Status;

abstract class EntityI extends ObjectI implements ISessionableI {

    
    public readonly string $id;

    public function __construct( ?string $id = null ) {

        parent::__construct();

        $this->setId( $id ?? Status::UNKNOWN->value . "-" . $this->hashCode() );
    }


    public function setId( string $id ): void {

        $this->id = $id;
    }

    /**
     * 
     * {@inheritdoc}
     * @return class-string<ISessionableI>
     */
    public function getType(): mixed {

        return $this::class;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function __serialize(): array
    {
        return [
            "id" => base64_encode($this->id)
        ];
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function __unserialize(array $data): void
    {
        $this->id = base64_decode($data["id"]);
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function __wakeup(): void {

    }


}