<?php

namespace Generics\Tests\Cases;

use \Generics\Tests\GenericsTestCase;
use \Generics\Tests\Classes\DictionaryOf;

class DictionaryOfTest extends GenericsTestCase {
    
    public function testGenericInstantiation() {
        new DictionaryOf\stdClass\_\stdClass();
        new DictionaryOf\stdClass\_\DateTime();
        new DictionaryOf\Hello\_\World();
    }
    
    public function testValidKeysAndValuesAreAdded() {
        $Dictionary = new DictionaryOf\stdClass\_\stdClass();
        $Dictionary[new \stdClass()] = new \stdClass();
        $Dictionary[new \stdClass()] = new \stdClass();
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Key for dictionary must be of type stdClass: DateTime given
     */
    public function testInvalidKeysAreRejected() {
        $Dictionary = new DictionaryOf\stdClass\_\stdClass();
        $Dictionary[new \DateTime()] = new \stdClass();
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Value for dictionary must be of type stdClass: DateTime given
     */
    public function testInvalidValuesAreRejected() {
        $Dictionary = new DictionaryOf\stdClass\_\stdClass();
        $Dictionary[new \stdClass()] = new \DateTime();
    }
}

?>