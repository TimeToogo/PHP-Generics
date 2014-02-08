<?php

namespace Generics\Tests\Cases;

use \Generics\Tests\GenericsTestCase;
use \Generics\Tests\Classes\Converts;

class SendsTraitTest extends GenericsTestCase {

    public function testGenericTraitInstanstiation() {
        new Implementations\Converter();
    }

    public function testValidGenericWorks() {
        $Converter = new Implementations\Converter();
        $Converted = $Converter->ConvertClass(new \stdClass());
        
        $this->assertSame((array)new \stdClass(), $Converted);
    }
    
}

?>