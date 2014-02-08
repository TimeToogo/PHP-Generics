<?php

namespace Generics\Tests\Classes\ArrayOf\Generics\Tests\Classes\ArrayOf;

class stdClass extends \ArrayObject
{
    public function offsetSet($Index, $Value)
    {
        $this->VerifyValue($Value);
        parent::offsetSet($Index, $Value);
    }
    public function exchangeArray($Array)
    {
        foreach ($Array as $Value) {
            $this->VerifyValue($Value);
        }
        parent::exchangeArray($Array);
    }
    private function VerifyValue($Value)
    {
        if (!$Value instanceof \Generics\Tests\Classes\ArrayOf\stdClass) {
            throw new \InvalidArgumentException(sprintf('Expecting type %s: %s given', 'Generics\\Tests\\Classes\\ArrayOf\\stdClass', get_class($Value)));
        }
    }
}