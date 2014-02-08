<?php

namespace Generics\Tests\Cases;

use \Generics\Tests\GenericsTestCase;
use \Generics\Tests\Classes\ArrayOf;

class ArrayOfTest extends GenericsTestCase {
    
    public function testGenericInstantiation() {
        new ArrayOf\stdClass();
        new ArrayOf\DateTime();
        new ArrayOf\I_Dont_Exist();
    }
    
    public function testValidValuesAreAdded() {
        $ArrayOfstdClass = new ArrayOf\stdClass();
        $ArrayOfstdClass[] = new \stdClass();
        $ArrayOfstdClass[] = new \stdClass();
        $ArrayOfstdClass[] = new \stdClass();
    }
    
    public function testNestedGeneric() {
        $ArrayOfArrayOfstdClass = new ArrayOf\Generics\Tests\Classes\ArrayOf\stdClass();
        $ArrayOfstdClass = new ArrayOf\stdClass();
        $ArrayOfstdClass[] = new \stdClass();
        $ArrayOfArrayOfstdClass[] = $ArrayOfstdClass;
    }
    
    public function testInheritedGenericValuesAreAdded() {
        $Array = new Implementations\ArrayOfDates();
        $Array[] = new \DateTime();
        $Array[] = new \DateTime();
    }
    
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Expecting type DateTime: stdClass given
     */
    public function testInheritedGenericValuesAreRejected() {
        $Array = new Implementations\ArrayOfDates();
        $Array[] = new \stdClass();
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Expecting type stdClass: DateTime given
     */
    public function testInvalidValuesAreRejected() {
        $ArrayOfstdClass = new ArrayOf\stdClass();
        $ArrayOfstdClass[] = new \DateTime();
    }
}

?>