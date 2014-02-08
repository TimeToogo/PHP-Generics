<?php

namespace Generics\Tests\Classes;

trait Converts {
    
    public function Convert(__TYPE__ $Value) {
        return (array)$Value;
    }
}

?>