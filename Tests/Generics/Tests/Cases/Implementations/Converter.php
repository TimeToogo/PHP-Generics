<?php

namespace Generics\Tests\Cases\Implementations;

use \Generics\Tests\Classes\Converts;

class Converter {
    use Converts\stdClass {
        Convert as ConvertClass;
    }
}

?>