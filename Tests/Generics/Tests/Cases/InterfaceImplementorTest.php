<?php

namespace Generics\Tests\Cases;

use \Generics\Tests\GenericsTestCase;
use \Generics\Tests\Classes\InterfaceImplementor;

class InterfaceImplementorTest extends GenericsTestCase {
    
    public function testGenericInstantiation() {
        new InterfaceImplementor\IteratorAggregate();
    }
    
    public function testHasExtendsType() {
        $ImplementorIterator = new InterfaceImplementor\IteratorAggregate();
        
        $this->assertInstanceOf('\IteratorAggregate', $ImplementorIterator);
    }
    
    public function testHasWrapperFunction() {
        $ImplementorIterator = new InterfaceImplementor\IteratorAggregate();
        
        $this->assertTrue($ImplementorIterator->DoStuff());
    }
}

?>