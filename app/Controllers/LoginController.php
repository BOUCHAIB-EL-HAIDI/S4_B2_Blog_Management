<?php
namespace App\Controllers;


use Core\Controller;
use Core\Database;
use Models\Reader;
use Models\Author;
use Models\Admin;
use Models\User;
use App\Controllers\AuthController;

class LoginController extends Controller 
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->view('login', []);
            return;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $errors = [];

        if (empty($email) || empty($password)) {
            $errors[] = "Tous les champs sont obligatoires";
            $this->view('login', ['errors' => $errors]);
            return;
        }

        $auth = new AuthController();
        $user = $auth->findByEmail($email);

        if (!$user) {
            $errors[] = "Email ou mot de passe incorrect";
            $this->view('login', ['errors' => $errors]);
            return;
        }

        
        if (!password_verify($password, $user['password'])) {
            $errors[] = "Email ou mot de passe incorrect";
            $this->view('login', ['errors' => $errors]);
            return;
        }

        
       switch ($user['role']) {
    case 'reader':
        $loggedInUser = new Reader($user['id'], $user['name'], $user['email'], $user['password']);
        break;
    case 'author':
        $loggedInUser = new Author($user['id'], $user['name'], $user['email'], $user['password']);
        break;
    case 'admin':
        $loggedInUser = new Admin($user['id'], $user['name'], $user['email'], $user['password']);
        break;
    }
        
        $_SESSION['user_id'] = $loggedInUser->getId();
        $_SESSION['user_name'] = $loggedInUser->getName();
        $_SESSION['user_email'] = $loggedInUser->getEmail();
        $_SESSION['user_role'] = $loggedInUser->getRole();
        $_SESSION['success'] = "Bienvenue " . $loggedInUser->getName();
    
        
        header('Location: /');
        exit;
    }

       public function logout()
    {
        
        $userName = $_SESSION['user_name'] ?? 'utilisateur';
        
        
        $_SESSION = [];
        
        
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }
        
        
        session_destroy();
        
        
        // session_start();
        // $_SESSION['success'] = "Au revoir " . htmlspecialchars($userName) . "! Vous êtes déconnecté.";
        
       
        header('Location: /');
        exit;
    }
}
