<?php

namespace Generics\Tests\Classes\ArrayOf;

class I_Dont_Exist extends \ArrayObject
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
        if (!$Value instanceof \I_Dont_Exist) {
            throw new \InvalidArgumentException(sprintf('Expecting type %s: %s given', 'I_Dont_Exist', get_class($Value)));
        }
    }
}