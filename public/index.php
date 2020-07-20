<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Slim\Factory\AppFactory;

$loader = require_once '../vendor/autoload.php';

$loader->add('Documents', __DIR__);

AnnotationRegistry::registerLoader([$loader, 'loadClass']);

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

/** @var ContainerBuilder $containerBuilder */
$containerBuilder = new ContainerBuilder();

// Set up settings
$settings = require __DIR__ . '/../app/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Instantiate the app
AppFactory::setContainer($container);
$app = AppFactory::create();

/** @var bool $displayErrorDetails */
$displayErrorDetails = $container->get('settings')['displayErrorDetails'];

$app->addErrorMiddleware($displayErrorDetails, false, false);

// Register routes
$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

$app->run();