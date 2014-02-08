<?php

namespace Generics\Tests;


abstract class GenericsTestCase extends \PHPUnit_Framework_TestCase {
    public function __construct() {
        parent::__construct();
        $this->InitializeGenerics();
    }
    
    protected function InitializeGenerics() {
        $Configuration = new \Generics\Configuration();
        $Configuration->SetIsDevelopmentMode(true);
        $Configuration->SetRootPath(dirname(dirname(__DIR__)));
        $Configuration->SetCachePath(__DIR__ . '/Cache');
        \Generics\Loader::Register($Configuration);
    }
}

?>