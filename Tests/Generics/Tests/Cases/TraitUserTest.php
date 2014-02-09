<?php

namespace {
    trait EmptyTrait {}
}

namespace Generics\Tests\Cases {
    
use \Generics\Tests\GenericsTestCase;
use \Generics\Tests\Classes\TraitUser;

class TraitUserTest extends GenericsTestCase {

    public function testGenericInstantiation() {
        new TraitUser\EmptyTrait();
        new TraitUser\Generics\Tests\Classes\Converts\stdClass();
    }

    public function testUsesGenericType() {
        $TraitUser = new TraitUser\EmptyTrait();

        $this->assertTrue(in_array('EmptyTrait', class_uses($TraitUser)));
    }

    public function testUsesNestedGenericTypes() {
        $TraitUser = new TraitUser\Generics\Tests\Classes\Converts\stdClass();

        $this->assertSame((array)new \stdClass(), $TraitUser->Convert(new \stdClass()));
    }
}

}

?>