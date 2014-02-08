<?php

namespace Generics\Tests\Classes\Maybe;

class stdClass
{
    private $MaybeValue;
    public function __construct(\stdClass $Value = null)
    {
        $this->MaybeValue = $Value;
    }
    public function HasValue()
    {
        return $this->MaybeValue !== null;
    }
    public function GetValue()
    {
        return $this->MaybeValue;
    }
    public function SetValue(\stdClass $Value = null)
    {
        $this->MaybeValue = $Value;
    }
}