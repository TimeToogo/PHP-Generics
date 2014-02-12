<?php

namespace Generics\Tests\Cases;

use \Generics\Tests\GenericsTestCase;
use \Generics\Tests\Classes\Maybe;

class MaybeTest extends GenericsTestCase {

    public function testMaybeInstantiation() {
        new Maybe\stdClass();
    }

    public function testMaybeWithValueHasValue() {
        $Maybe = new Maybe\stdClass(new \stdClass());
        $this->assertTrue($Maybe->HasValue());
    }
    
    public function testMaybeWithoutValueDoesNotHaveValue() {
        $Maybe = new Maybe\stdClass();
        $this->assertFalse($Maybe->HasValue());
    }
    
    public function testMaybeValueIsCorrect() {
        $Object = new \stdClass();
        $Maybe = new Maybe\stdClass($Object);
        $this->assertSame($Object, $Maybe->GetValue());
        
        $Maybe->SetValue(null);
        $this->assertSame(null, $Maybe->GetValue());
    }
    
    /**
     * @expectedException ErrorException
     * @expectedExceptionMessage Failure to load generic type: Empty type parameter
     */
    public function testEmptyGenericTypeFailsInstantiation() {
        $Maybe = new Maybe\_();
    }
    
}

?>