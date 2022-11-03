<?php

declare(strict_types = 1);

require __DIR__ . '/../vendor/autoload.php';

define('STORAGE_PATH', __DIR__ . '/../storage');
define('VIEW_PATH', __DIR__ . '/../views');

use ImageModifier\Routing\RouteCollection;
use ImageModifier\Routing\Router;
use ImageModifier\Routing\Route;

$collection = new RouteCollection();

// Route for the sample page - http://image-service/sample-page
$collection->attachRoute(new Route('/^\/sample-page$/', [
    '_controller' => 'ImageModifier\\Controllers\\MainController::samplePageAction',
    'methods' => 'GET'
]));

// Route for the image modifier - ex. http://image-service/screen.png/crop/100/200
$collection->attachRoute(new Route('/^\/(?P<image>[a-zA-Z0-9_.\-]+)\/(?P<modifier>(crop|resize))\/(?P<width>\d+)\/(?P<height>\d+)$/', [
    '_controller' => 'ImageModifier\\Controllers\\MainController::modifierAction',
    'methods' => 'GET'
]));

// Route to view the modified images - ex. http://image-service/modified-image-name.png
$collection->attachRoute(new Route('/^\/(?P<image>[a-zA-Z0-9_.\-]+)$/', [
    '_controller' => 'ImageModifier\\Controllers\\MainController::showAction',
    'methods' => 'GET'
]));

// For all other routes we are showing 404 error page
$collection->attachRoute(new Route('/^\/.*$/', [
    '_controller' => 'ImageModifier\\Controllers\\MainController::errorAction',
    'methods' => 'GET'
]));

$router = new Router($collection);
$router->setBasePath('/');
$route = $router->matchCurrentRequest();
