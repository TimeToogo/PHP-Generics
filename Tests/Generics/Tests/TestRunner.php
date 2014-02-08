<?php

namespace Generics\Tests;

require_once 'TestBootstrapper.php';

$argv = array(
    '--configuration', 'Configuration.xml',
    './',
);
$_SERVER['argv'] = $argv;
echo '<pre>';
\PHPUnit_TextUI_Command::main();
?>