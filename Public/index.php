<?php

require_once __DIR__ . '/../bootstrap/autoload.php';
use Core\Router;
session_start();

$router = new Router();
$router->get('/', "HomeController@index");
$router->get('/about', "HomeController@index");
$router->dispatch();