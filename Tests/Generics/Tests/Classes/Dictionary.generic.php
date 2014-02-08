<?php

namespace Generics\Tests\Classes;

class Dictionary implements \ArrayAccess, \Iterator, \Countable {
    private $Keys = array();
    private $Values = array();
    private $Position = 0;
    
    public function count() {
        return count($this->Keys);
    }

    public function current() {
        return $this->Values[$this->Position];
    }

    public function key() {
        return $this->Keys[$this->Position];
    }

    public function next() {
        $this->Position++;
    }

    public function rewind() {
        $this->Position = 0;
    }

    public function valid() {
        return isset($this->Keys[$this->Position]);
    }
    
    private function VerifyKey($Key) {
        if(!($Key instanceof __TYPE1__)) {
            throw new \InvalidArgumentException(
                    sprintf('Key for dictionary must be of type %s: %s given', __TYPE1__, get_class($Key)));
        }
    }

    private function VerifyValue($Value) {
        if(!($Value instanceof __TYPE2__)) {
            throw new \InvalidArgumentException(
                    sprintf('Value for dictionary must be of type %s: %s given', __TYPE2__, get_class($Value)));
        }
    }

    public function offsetExists($Key) {
        $this->VerifyKey($Key);
        return array_search($Key, $this->Keys, true) !== false;
    }

    public function offsetGet($Key) {
        $this->VerifyKey($Key);
        return $this->Values[array_search($Key, $this->Keys, true)];
    }

    public function offsetSet($Key, $Value) {
        $this->VerifyKey($Key);
        $this->VerifyValue($Value);
        if($this->offsetExists($Key)) {
            $this->Values[array_search($Key, $this->Keys, true)] = $Value;
        }
        $this->Keys[] = $Key;
        $this->Values[] = $Value;
    }

    public function offsetUnset($Key) {
        $this->VerifyKey($Key);
        if($this->offsetExists($Key)) {
            $ValueKey = array_search($Key, $this->Keys, true);
            unset($this->Keys[$ValueKey], $this->Values[$ValueKey]);
        }
    }
    
}

?>