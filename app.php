#!/usr/bin/env php
<?php declare(strict_types=1);
require __DIR__.'/vendor/autoload.php';

use App\Application;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__.'/.env');

$containerBuilder = new ContainerBuilder();
$loader = new YamlFileLoader($containerBuilder, new FileLocator(__DIR__.'/config'));
$loader->load('services.yaml');

$containerBuilder->compile(true);

$app = $containerBuilder->get(Application::class);
$app->setCatchExceptions(false);
exit($app->run());
