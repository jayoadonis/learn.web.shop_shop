<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models\entities;

use learn\web\shop_shop\models\Status;

/**
 * Example User class that implements ISessionable.
 * The __sleep() method ensures that only the USER_NAME and email properties
 * are serialized, excluding sensitive properties such as the password.
 */
class User extends Entity {

    
    public readonly string $userName;
    protected string $email             = Status::UNKNOWN->value;
    public string|Status $password      = Status::PROTECTED;

    public function __construct(
        ?string $id         = null,
        ?string $userName   = null,
        ?string $email      = null,
        ?string $password   = null
    ) {

        parent::__construct($id ?? "default:{".$this::class."}");

        $this->email    = $email    ?? Status::UNKNOWN->value;
        $this->userName = $userName ?? Status::UNKNOWN->value;
        $this->password = $password ?? Status::PROTECTED;

    }

    /**
     * Sets the email.
     *
     * @param string $email
     * @return void
     */
    public function setEmail(string $email): void {
        $this->email = $email;
    }

    /**
     * Gets the email.
     *
     * @return string|null
     */
    public function getEmail(): ?string {
        return $this->email;
    }

    /**
     * Returns a canonical class name to be used as a session key.
     *
     * @return string
     */
    public function getType(): string {
        return self::class;
    }

    /**
     * __sleep() controls which properties are serialized.
     *
     * @return string[]
     */
    public function __sleep(): array {

        return array_merge(["userName", "email"], parent::__sleep());
    }

    /**
     * __wakeup() can be used to reinitialize any resources after unserialization.
     *
     * @return void
     */
    public function __wakeup(): void {

        parent::__wakeup();
        //REM: Reinitialize resources or perform other post-unserialization tasks.
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function hashCode(): int {

        return parent::hashCode() + crc32( 
            $this->userName .
            $this->email
        );
    }
}