<?php

define('PHP_MVC_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
*/
require __DIR__ . '/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Load environment variables
|--------------------------------------------------------------------------
*/
\Chr15k\Core\Support\Env::loadDotenv();

/*
|--------------------------------------------------------------------------
| Bootstrap error handling
|--------------------------------------------------------------------------
*/
$errorHandling = new \Chr15k\Core\Bootstrap\HandleExceptions();
$errorHandling->bootstrap();

/*
|--------------------------------------------------------------------------
| Register application routes
|--------------------------------------------------------------------------
*/
$router = new \Chr15k\Core\Routing\Router();

$router->register('/posts', [
    'controller' => 'Post',
    'action'     => 'index'
]);

$router->register('/posts/{id}', [
    'controller' => 'Post',
    'action'     => 'show'
]);

$request = new \Chr15k\Core\Http\Request();

$router->dispatch($request);
