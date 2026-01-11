<?php

require_once __DIR__ . '/../bootstrap/session.php';
require_once __DIR__ . '/../bootstrap/autoload.php';

use Core\Router;



$router = new Router();

$router->get('/', "HomeController@index");

$router->get('/404', "NotFoundController@index");


$router->get('/about', "HomeController@about");
$router->get('/profile', "ProfileController@index");


$router->get('/signup', "AuthController@signup");
$router->post('/signup', "AuthController@signup");
$router->get('/login', "LoginController@login");
$router->post('/login', "LoginController@login");
$router->get('/logout', "LoginController@logout");



$router->get('/articles', "ArticleController@index");



$router->post('/article/comment', "CommentController@addComment");
$router->get('/comment/delete', "CommentController@deleteComment");
$router->post('/article/like', "LikeController@toggleLike");


$router->get('/author/dashboard', "AuthorController@dashboard");
$router->get('/author/articles/create', "AuthorController@create");
$router->post('/author/articles/create', "AuthorController@create");
$router->get('/author/articles/edit', "AuthorController@edit");
$router->post('/author/articles/edit', "AuthorController@update");
$router->get('/author/articles/delete', "AuthorController@delete");


$router->get('/admin/dashboard', "AdminController@dashboard");
$router->get('/admin/categories', "AdminController@categories");
$router->post('/admin/categories/create', "AdminController@createCategory");
$router->get('/admin/categories/edit', "AdminController@editCategory");
$router->post('/admin/categories/edit', "AdminController@updateCategory");
$router->get('/admin/categories/delete', "AdminController@deleteCategory");

$router->dispatch();