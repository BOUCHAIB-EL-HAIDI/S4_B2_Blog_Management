<?php

require_once __DIR__ . '/../bootstrap/autoload.php';
use Core\Router;
session_start();

$router = new Router();
$router->get('/', "HomeController@index");
$router->get('/login', "LoginController@login");
$router->get('/signup', "SignupController@signup");
$router->dispatch();