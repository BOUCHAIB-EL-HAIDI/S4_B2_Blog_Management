<?php
namespace App\Controllers;

use Core\Controller;
use Core\Database;
use Models\Reader;

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

        if (empty($email) || empty($password)) {
            $this->view('login', ['error' => 'Tous les champs sont obligatoires']);
            return;
        }

        $user = new Reader($this->pdo);

        if ($user->login($email, $password)) {
            $userData = Reader::findByEmail($this->pdo, $email);
            $_SESSION['user_id'] = $userData['id'];
            $_SESSION['user_name'] = $userData['name'];
            $_SESSION['user_email'] = $userData['email'];
            $_SESSION['user_role'] = $userData['role'];
            $_SESSION['success'] = "Bienvenue " . $userData['name'];

            header('Location: /');
            exit;
        } else {
            $this->view('login', ['error' => 'Email ou mot de passe incorrect']);
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: /');
        exit;
    }
}