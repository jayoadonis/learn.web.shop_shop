<?php
declare(strict_types=1);

namespace learn\web\shop_shop\utils;

use learn\web\shop_shop\models\ObjectI;
use learn\web\shop_shop\models\Status;

/**
 * 
 * @template T
 */
final class Option extends ObjectI {


    /**
     * 
     * @var bool
     */
    private bool $hasValue;

    /**
     * 
     * @var T|null
     */
    private $value;


    private static ?self $none = null;

    /**
     * 
     * @param bool $hasValue
     * @param T|null $value
     */
    private function __construct(
        bool $hasValue,
        mixed $value = null
    ) {

        $this->hasValue = $hasValue;
        
        $this->value = $value;
    }


    /**
     * @param T $value
     * 
     * @return self<T>
     */
    public static function some(mixed $value): self {

        // if( $value === null ) self::none();

        return new self(true, $value);
    }

    /**
     * 
     * @return self<T>
     */
    public static function none(): self {

        if( self::$none === null ) self::$none = new self(false);

        return self::$none;

        // return new self(false);
    }

    public function isSome(): bool {

        return $this->hasValue;
    }

    public function isNone(): bool {

        return !$this->hasValue;
    }


    /**
     * 
     * @return T The contained Value
     * @throws \LogicException If the option is empty
     */
    public function unwrap( bool $sanitizeStr = true ): mixed {

        if( $this->isNone() )  {
            
            throw new \LogicException("Called unwrap() on a None option");
        }
        
        return is_string($this->value)
            ? ( $sanitizeStr
                ? htmlentities( $this->value, ENT_QUOTES|ENT_SUBSTITUTE, "UTF-8" ) 
                : $this->value )
            : $this->value;
    }


    /**
     * 
     * @template U The return type
     * @param callable(T): U $callback A function to transform a value
     * @return Option<U> A new Option containing the transformed value if present, other-wise None.
     */
    public function map( callable $callback ): self {

        if( $this->isSome() )
            return self::some( $callback($this->value) );

        return self::none();
    }

    /**
     * 
     * @param T $default The default value to return if empty
     * @return T The contained value or the default
     */
    public function getOrElse( mixed $default, bool $sanitizeStr = true ): mixed {

        try {

            $value = $this->unwrap($sanitizeStr);
        }
        catch( \Exception $ignoreE ) {

            $default = Option::some($default);

            return $default->unwrap($sanitizeStr);
        }

        return $value;

        // return $isSanitize 
        //     ? htmlentities( $value, ENT_QUOTES|ENT_SUBSTITUTE, "UTF-8")
        //     : $value;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function hashCode(): int {

        return crc32(
            $this->value??Status::UNKNOWN->toString()
        );
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @param Option<T>|ObjectI|object|array|int|float|null $obj
     */
    public function equals( mixed $obj ): bool {
 
        if( !( $obj instanceof self ) ) return false;

        return parent::equals( $obj )
            || $obj->value === $this->value;
    }
        
}