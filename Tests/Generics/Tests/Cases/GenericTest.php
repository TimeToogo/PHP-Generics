<?php

namespace Generics\Tests\Cases;

use \Generics\Tests\GenericsTestCase;
use \Generics\Tests\Classes\IGeneric;

class GenericTest extends GenericsTestCase {

    public function testValidGenericImplementation() {
        new Implementations\ValidGeneric();
    }

    public function testValidGenericWorks() {
        $Generic = new Implementations\ValidGeneric();
        $Generic->DoStuff(new \stdClass());
    }
    
}

?>