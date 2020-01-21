<?php

require __DIR__ . '/../vendor/autoload.php';

use \DI\ContainerBuilder;

$builder = new ContainerBuilder();
$builder->useAnnotations(false);
$builder->useAutowiring(true);
$builder->addDefinitions(__DIR__ . '/config.php');
$container = $builder->build();

return $container;