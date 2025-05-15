<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models\entities;

use learn\web\shop_shop\modles\entities\EntityI;

class User extends EntityI {


    public function __construct() {
        
        parent::__construct();
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function __serialize(): array
    {
        
        return [];
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function __unserialize(array $data): void
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function __wakeup(): void {

    }
}
