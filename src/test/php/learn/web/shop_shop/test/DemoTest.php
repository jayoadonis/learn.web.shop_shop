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
        print "static destructor\n";
    }

    /**
     * 
     * @before
     */
    public function init(): void {
        print "instance init...\n";
    }

    /**
     * 
     * @after
     */
    public function desctruct(): void {
        print "instance destructor...\n";
    }
    
    /**
     * 
     * @test
     * @depends three
     */
    public function one(): void {
        print "method one...\n";
    }

        
    /**
     * 
     * @test
     */
    public function two(): void {
        print "method two...\n";
    }

            
    /**
     * 
     * @test
     * @depends four
     */
    public function three(): void {
        print "method three...\n";
    }

    /**
     * @test
     * 
     */
    public function four(): void {
        print "method four...\n";
    }
}