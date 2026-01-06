<?php
namespace App\Controllers;

use Core\Controller;
class LoginController extends Controller {



public function login(){

    $this->view('login' , []);
}

}