<?php

namespace Generics\Tests;

date_default_timezone_set('Australia/Melbourne');
error_reporting(-1);
ini_set('display_errors', 'On');

$GenericsAsProjectAutoLoaderPath = __DIR__ . '/../../../vendor/autoload.php';
$GenericsAsDependencyAutoLoaderPath = __DIR__ . '/../../../../../../autoload.php';

if(file_exists($GenericsAsProjectAutoLoaderPath)) {
    $ComposerAutoLoader = require $GenericsAsProjectAutoLoaderPath;
}
else if(file_exists($GenericsAsDependencyAutoLoaderPath)) {
    $ComposerAutoLoader = require $GenericsAsDependencyAutoLoaderPath;
}
else {
    throw new \Exception('Cannot load generic tests: please install Generics via composer.');
}

$ComposerAutoLoader->add(__NAMESPACE__, __DIR__ . '/../../');

?>