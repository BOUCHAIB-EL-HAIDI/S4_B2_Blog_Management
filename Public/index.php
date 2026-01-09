<?php

require_once __DIR__ . '/../bootstrap/session.php';
require_once __DIR__ . '/../bootstrap/autoload.php';

use Core\Router;



$router = new Router();

$router->get('/', "HomeController@index");

$router->get('/signup', "AuthController@signup");
$router->post('/signup', "AuthController@signup");

$router->get('/login', "LoginController@login");
$router->post('/login', "LoginController@login");

$router->get('/logout', "LoginController@logout");
$router->get('/about', "HomeController@about");
$router->get('/profile', "ProfileController@index");
$router->get('/admin/dashboard', "AdminController@dashboard");
$router->get('/author/dashboard', "AuthorController@dashboard");


$router->get('/profile', "ProfileController@index");


$router->get('/author/dashboard', "AuthorController@dashboard");
$router->get('/author/articles/create', "AuthorController@create");
$router->post('/author/articles/create', "AuthorController@create");
$router->get('/author/articles/edit/{id}', "AuthorController@edit");
$router->post('/author/articles/edit/{id}', "AuthorController@edit");
$router->get('/author/articles/delete/{id}', "AuthorController@delete");


$router->get('/admin/dashboard', "AdminController@dashboard");
$router->get('/admin/categories', "AdminController@categories");

$router->dispatch();