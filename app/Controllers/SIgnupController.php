<?php
namespace App\Controllers;

use Core\Controller;
class SignupController extends Controller {



public function signup(){

    $this->view('signup' , []);
}



}