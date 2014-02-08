<?php

namespace Generics\Tests\Classes;

class ArrayOf extends \ArrayObject {
    public function offsetSet($Index, $Value) {
        $this->VerifyValue($Value);
        parent::offsetSet($Index, $Value);
    }
    
    public function exchangeArray($Array) {
        foreach ($Array as $Value) {
            $this->VerifyValue($Value);
        }
        parent::exchangeArray($Array);
    }
    
    private function VerifyValue($Value) {
        if(!($Value instanceof __TYPE__)) {
            throw new \InvalidArgumentException(
                    sprintf('Expecting type %s: %s given', __TYPE__, get_class($Value)));
        }
    }
}

?>