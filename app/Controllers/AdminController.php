<?php
namespace App\Controllers;

use Core\Controller;
use Core\Database;

class AdminController extends Controller
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    private function checkAdmin()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            $_SESSION['error'] = "Accès non autorisé";
            header('Location: /login');
            exit;
        }
    }

    public function dashboard()
    {
        $this->checkAdmin();
        $this->view('admin/dashboard', [
            'title' => 'Dashboard Admin - MyBlog'
        ]);
    }

    public function categories()
    {
        $this->checkAdmin();
        
        $stmt = $this->pdo->query("SELECT * FROM categories ORDER BY name");
        $categories = $stmt->fetchAll();

        $this->view('admin/categories', [
            'title' => 'Gestion des Catégories - Admin',
            'categories' => $categories
        ]);
    }

    public function createCategory()
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');

            if (!empty($name)) {
                $stmt = $this->pdo->prepare("INSERT INTO categories (name) VALUES (?)");
                if ($stmt->execute([$name])) {
                    $_SESSION['success'] = "Catégorie créée avec succès.";
                } else {
                    $_SESSION['error'] = "Erreur lors de la création.";
                }
            } else {
                $_SESSION['error'] = "Le nom ne peut pas être vide.";
            }
        }
        header('Location: /admin/categories');
        exit;
    }

    public function editCategory()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) { header('Location: /admin/categories'); exit; }

        $this->checkAdmin();
        

        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        $category = $stmt->fetch();

        if (!$category) {
            header('Location: /admin/categories');
            exit;
        }

        $this->view('admin/categories', [
            'title' => 'Modifier Catégorie - Admin',
            'categories' => $this->pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll(),
            'edit_category' => $category
        ]);
    }
    
    public function updateCategory()
    {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null; 
            if (!$id) { header('Location: /admin/categories'); exit; } 
            $name = trim($_POST['name']);
            if (!empty($name)) {
                $stmt = $this->pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
                $stmt->execute([$name, $id]);
                $_SESSION['success'] = "Catégorie modifiée.";
            }
            header('Location: /admin/categories');
        }
    }
    
    public function deleteCategory()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) { header('Location: /admin/categories'); exit; }
        
        $this->checkAdmin();
        $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['success'] = "Catégorie supprimée.";
        header('Location: /admin/categories');
    }
}