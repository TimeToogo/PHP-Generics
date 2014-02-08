<?php

namespace Generics\Tests\Cases;

use \Generics\Tests\GenericsTestCase;
use \Generics\Tests\Classes\Dictionary;

class DictionaryTest extends GenericsTestCase {
    
    public function testGenericInstantiation() {
        new Dictionary\stdClass\_\stdClass();
        new Dictionary\stdClass\_\DateTime();
        new Dictionary\Hello\_\World();
    }
    
    public function testValidKeysAndValuesAreAdded() {
        $Dictionary = new Dictionary\stdClass\_\stdClass();
        $Dictionary[new \stdClass()] = new \stdClass();
        $Dictionary[new \stdClass()] = new \stdClass();
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Key for dictionary must be of type stdClass: DateTime given
     */
    public function testInvalidKeysAreRejected() {
        $Dictionary = new Dictionary\stdClass\_\stdClass();
        $Dictionary[new \DateTime()] = new \stdClass();
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Value for dictionary must be of type stdClass: DateTime given
     */
    public function testInvalidValuesAreRejected() {
        $Dictionary = new Dictionary\stdClass\_\stdClass();
        $Dictionary[new \stdClass()] = new \DateTime();
    }
}

?>