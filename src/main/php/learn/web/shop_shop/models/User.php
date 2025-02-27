<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models;


class User extends Entity {

    public function __construct(
        ?string $id = null,
        public readonly string $USER_NAME,
        protected ?string $email = null,
    ) {
        parent::__construct($id??"N/a");
    }

    public function setEmail(
        string $email
    ): void {

        $this->email = $email;
    }

    public function getEmail(): ?string {

        return $this->email;
    }

    /**
     * [TODO]
     * @inheritDoc ISessionable::getData()
     * @return User|array<string,mixed>|string|null
     */
    public function getData(): User|array|string|null {

        return $this;
    }

    /**
     * @inheritDoc ISessionable::getType()
     * @return class-string<ISessionable> A cannonical classname
     */
    public function getType(): mixed {

        return $this->TYPE;
    }

    /**
     * 
     * @return string[]
     * @inheritdoc
     */
    public function __sleep(): array {

        return ["USER_NAME", "email"];
    }
}