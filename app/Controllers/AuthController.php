<?php

namespace App\Controllers;

use Core\Controller;
use Core\Database;
use PDO;

class AuthController extends Controller
{
    private $pdo;

    public function __construct()
    {
        
        $this->pdo = Database::getInstance()->getConnection();
    }

    
    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function signup()
    {
        
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $this->view('signup', ['title' => 'Signup Page']);
            return;
        }

        
        $data = $this->dataVerification();
        if (!$data) return; 

        
        $stmt = $this->pdo->prepare(
            "INSERT INTO users (name, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())"
        );

        $stmt->execute([
            $data['name'],
            $data['email'],
            $data['password'],
            $data['role']
        ]);

        $_SESSION['success'] = "User was created successfully now you can log in";

        header("Location: /login");
        exit;
    }

    public function dataVerification()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'reader';

            $errors = [];

          
            if (empty($name) || !preg_match('/^[\p{L} ]{3,}$/u', $name)) {
                $errors['name'] = "Le nom doit contenir au moins 3 caractères et uniquement des lettres.";
            }

            
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Email invalide";
            }

            
            if (empty($errors) && $this->findByEmail($email)) {
                $errors['email'] = "Cet email est déjà utilisé";
            }

            
            if (empty($password) || !preg_match('/^(?=.*[A-Za-z])(?=.*\d).{6,}$/', $password)) {
                $errors['password'] = 'Le mot de passe doit contenir au moins 6 caractères et inclure lettres et chiffres.';
            }

            
            if (!empty($errors)) {
                $this->view('signup', [
                    'errors' => $errors,
                         'old' => [
                    'name' => $name,
                    'email' => $email,
                    'role' => $role
             ]
            
            
            
            ]);
                return null; 
            }

            
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            
            return [
                'name' => $name,
                'email' => $email,
                'password' => $hashedPassword,
                'role' => $role
            ];
        }

        return null;
    }
}
