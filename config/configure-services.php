<?php

/**
 * Initialises the service container
 */

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

$container = new ContainerBuilder();

$loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../'));
$loader->load('config/services.yml');

return $container;