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
        
        // Use existing categories view but pass update_id to show edit form or separate invalid approach?
        // Since I'm using modals or simple inline replacement, or maybe a dedicated edit page.
        // Let's use a simpler approach: Reuse the categories page but with a flag or specific data.
        // Actually, let's keep it simple: redirects to /admin/categories is fine for CREATE, but EDIT needs a form.
        // I will render the categories view with an 'edit_category' variable.
        
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
            $id = $_POST['id'] ?? null; // Re-added this line as removing it would break functionality
            if (!$id) { header('Location: /admin/categories'); exit; } // Re-added this line
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