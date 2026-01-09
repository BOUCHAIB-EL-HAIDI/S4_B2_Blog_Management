<?php
namespace App\Controllers;

use Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->view('home', [
            'title' => 'Accueil - MyBlog'
        ]);
    }
    
    public function about()
    {
        $this->view('about', [
            'title' => 'À propos - MyBlog'
        ]);
    }
}