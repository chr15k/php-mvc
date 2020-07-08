<?php

require __DIR__ . '/../vendor/autoload.php';

\Chr15k\Core\Support\Env::loadDotenv();

$router = new \Chr15k\Core\Routing\Router();

$router->register('/', [
    'controller' => 'Home',
    'action'     => 'index'
]);

$request = new \Chr15k\Core\Http\Request();
$router->dispatch($request);