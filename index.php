<?php

declare(strict_types=1);

require_once __DIR__ . '/App/bootstrap.php';

use App\Router;

$router = new Router();

$router
    ->add('/', function(){return 'Home'; }, 'get')
    ->add('/create', function(){return 'Create'; }, 'get')
    ;

echo $router->resolve();