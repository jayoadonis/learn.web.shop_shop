<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models\dbs;

use learn\web\shop_shop\models\ISessionable;
use learn\web\shop_shop\models\ObjectI;

final class DbConfig extends ObjectI implements ISessionable {

    public function __construct(
        public readonly string $provider    = "mysql",
        public readonly string $host        = "localhost",
        public readonly int $port           = 3306,
        public readonly ?string $dbName     = null,
    ) { }

    /**
     * 
     * {@inheritdoc}
     */
    public function __toString(): string {

        return sprintf(
            "%s[provider='%s', host='%s', port=%d, dbName='%s']",
            parent::__toString(),
            $this->provider,
            $this->host,
            $this->port,
            $this->dbName
        );

        // return strtr(
        //     "{cN}[provider='{provider}', host='{host}', port={port}, dbName='{dbName}']",
        //     [
        //         "{cN}"          => parent::__toString(),
        //         "{provider}"    => $this->provider,
        //         "{host}"        => $this->host,
        //         "{port}"        => $this->port,
        //         "{dbName}"      => $this->dbName
        //     ]
        // );
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function  hashCode(): int {

        return crc32( 
            $this->provider 
            . $this->host
            . $this->port
            . $this->dbName
        );
    }

    public function genericDSN(): string {

        return "{$this->provider}:host={$this->host};port={$this->port};dbname={$this->dbName}";
    }


    public function getType(): mixed {

        return $this::class;
    }

    public function __sleep(): array {

        return ["provider", "host", "port", "dbName"];
    }

    public function __wakeup(): void {
        
    }
}
