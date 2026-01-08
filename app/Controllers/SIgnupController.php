<?php
namespace App\Controllers;

use Core\Controller;
use Core\Database;
use Models\Reader;

class SignupController extends Controller
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->view('signup', []);
            return;
        }
        
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'reader';

        $errors = [];

        if (empty($name) || strlen($name) < 3) {
            $errors[] = "Le nom doit contenir au moins 3 caractères";
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email invalide";
        }

        if (empty($password) || strlen($password) < 6) {
            $errors[] = "Le mot de passe doit contenir au moins 6 caractères";
        }

        if (empty($errors) && $this->emailExists($email)) {
            $errors[] = "Cet email est déjà utilisé";
        }

        if (!empty($errors)) {
            $this->view('signup', ['errors' => $errors]);
            return;
        }

        $user = new Reader($this->pdo);
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => $role
        ];

        if ($user->signup($data)) {
            $userData = Reader::findByEmail($this->pdo, $email);
            $_SESSION['user_id'] = $userData['id'];
            $_SESSION['user_name'] = $userData['name'];
            $_SESSION['user_email'] = $userData['email'];
            $_SESSION['user_role'] = $userData['role'];
            $_SESSION['success'] = "Compte créé avec succès ! Bienvenue $name";

            header('Location: /');
            exit;
        } else {
            $this->view('signup', ['errors' => ['Erreur lors de la création du compte']]);
        }
    }

    private function emailExists(string $email): bool
    {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() !== false;
    }
}