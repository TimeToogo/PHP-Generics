<?php

namespace Generics\Tests\Classes;

class Maybe {
    private $MaybeValue;
    
    public function __construct(__TYPE__ $Value = null) {
        $this->MaybeValue = $Value;
    }
    
    public function HasValue() {
        return $this->MaybeValue !== null;
    }
    
    public function GetValue() {
        return $this->MaybeValue;
    }
    
    public function SetValue(__TYPE__ $Value = null) {
        $this->MaybeValue = $Value;
    }
}

?>