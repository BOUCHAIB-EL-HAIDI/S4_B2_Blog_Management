<?php
require_once __DIR__ . '/../bootstrap/autoload.php';
use Core\Router;

session_start();

$router = new Router();

$router->get('/', "HomeController@index");

$router->get('/signup', "AuthController@signup");
$router->post('/signup', "AuthController@signup");

$router->get('/login', "LoginController@login");
$router->post('/login', "LoginController@login");

$router->get('/logout', "LoginController@logout");

$router->dispatch();