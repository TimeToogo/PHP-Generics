<?php

namespace Generics\Tests\Classes\InterfaceImplementor;

class IteratorAggregate implements \IteratorAggregate
{
    public function DoStuff()
    {
        return true;
    }
    public function getIterator()
    {
        
    }
}