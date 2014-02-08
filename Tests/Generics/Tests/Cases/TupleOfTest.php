<?php

namespace Generics\Tests\Cases;

use \Generics\Tests\GenericsTestCase;
use \Generics\Tests\Classes\TupleOf;

class TupleOfTest extends GenericsTestCase {

    public function testValidTupleInstantiation() {
        new TupleOf\stdClass();
        new TupleOf\stdClass\_\stdClass();
        new TupleOf\stdClass\_\stdClass\_\stdClass();
        new TupleOf\stdClass\_\stdClass\_\stdClass\_\stdClass();
        new TupleOf\stdClass\_\stdClass\_\stdClass\_\stdClass\_\stdClass();
    }

    public function testTupleSetsData() {
        $ThreeTuple = new TupleOf\stdClass\_\stdClass\_\stdClass();
        $ThreeTuple->SetItem1(new \stdClass());
        $ThreeTuple->SetItem2(new \stdClass());
        $ThreeTuple->SetItem3(new \stdClass());
    }
    
    /**
     * @expectedException \PHPUnit_Framework_Error
     */
    public function testUntypedParameterIsRejected() {
        $ThreeTuple = new TupleOf\stdClass\_\stdClass\_\stdClass();
        $ThreeTuple->SetItem4(new \stdClass());
    }
    
}

?>