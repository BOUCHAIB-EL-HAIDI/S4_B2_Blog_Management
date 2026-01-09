<?php
namespace App\Controllers;

use Core\Controller;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            $_SESSION['error'] = "Accès non autorisé";
            header('Location: /');
            exit;
        }
        
        $this->view('admin/dashboard', [
            'title' => 'Dashboard Admin - MyBlog'
        ]);
    }
}