<?php

namespace Generics\Tests\Classes\ArrayOf;

class DateTime extends \ArrayObject
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
        if (!$Value instanceof \DateTime) {
            throw new \InvalidArgumentException(sprintf('Expecting type %s: %s given', 'DateTime', get_class($Value)));
        }
    }
}