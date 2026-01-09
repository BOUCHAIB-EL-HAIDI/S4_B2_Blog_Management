<?php
namespace App\Controllers;

use Core\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Vous devez être connecté pour accéder à cette page";
            header('Location: /login');
            exit;
        }
        
        $this->view('profile', [
            'title' => 'Mon Profil - MyBlog'
        ]);
    }
}