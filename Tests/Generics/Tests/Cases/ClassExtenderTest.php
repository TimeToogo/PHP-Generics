<?php

namespace Generics\Tests\Cases;

use \Generics\Tests\GenericsTestCase;
use \Generics\Tests\Classes\ClassExtender;

class ClassExtenderTest extends GenericsTestCase {
    
    public function testGenericInstantiation() {
        new ClassExtender\stdClass();
        new ClassExtender\DateTime();
    }
    
    public function testExtendsGenericType() {
        $ExtendsStdClass = new ClassExtender\stdClass();
        
        $this->assertInstanceOf('\stdClass', $ExtendsStdClass);
    }
    
    public function testHasWrapperFunction() {
        $ExtendsStdClass = new ClassExtender\stdClass();
        
        $this->assertTrue($ExtendsStdClass->HelloWorld());
    }
}

?>