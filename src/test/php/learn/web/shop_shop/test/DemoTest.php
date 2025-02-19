<?php
declare(strict_types=1);

namespace learn\web\shop_shop\test;

use PHPUnit\Framework\TestCase;

class DemoTest extends TestCase {

     /**
     * @inheritdoc
     */
    public static function setUpBeforeClass(): void
    {
        print "static init\n";
    }

    /**
     * @inheritdoc
     */
    public static function tearDownAfterClass(): void
    {
        print "static destruct\n";
    }

    /**
     * 
     * @before
     */
    public function init(): void {
        print "init...\n";
    }

    /**
     * 
     * @after
     */
    public function desctruct(): void {
        print "desctruct...\n";
    }
    
    /**
     * 
     * @test
     * @depends two
     */
    public function one(): void {
        print "one...\n";
    }

        
    /**
     * 
     * @test
     */
    public function two(): void {
        print "two...\n";
    }

            
    /**
     * 
     * @test
     * @depends one
     */
    public function three(): void {
        print "three...\n";
    }
}