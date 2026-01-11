<?php
namespace App\Controllers;

use Core\Controller;
use Core\Database;

class LikeController extends Controller
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function toggleLike()
    {
        
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Vous devez être connecté pour aimer un article.";
            header("Location: /articles");
            exit;
        }

        
        
        error_log("LikeController: User Role is " . ($_SESSION['user_role'] ?? 'NOT SET'));
        
        $articleId = $_POST['article_id'] ?? null;
        if (!$articleId) {
             header("Location: /articles");
             exit;
        }
        
        if (!in_array($_SESSION['user_role'], ['reader', 'author'])) {
            $_SESSION['error'] = "Action non autorisée. Rôle: " . htmlspecialchars($_SESSION['user_role']);
            header("Location: /articles");
            exit;
        }

        $userId = $_SESSION['user_id'];

        
        $stmt = $this->pdo->prepare("SELECT id FROM likes WHERE user_id = ? AND article_id = ?");
        $stmt->execute([$userId, $articleId]);
        $existingLike = $stmt->fetch();

        if ($existingLike) {
            
            $stmt = $this->pdo->prepare("DELETE FROM likes WHERE id = ?");
            $stmt->execute([$existingLike['id']]);
        } else {
            
            $stmt = $this->pdo->prepare("INSERT INTO likes (user_id, article_id) VALUES (?, ?)");
            $stmt->execute([$userId, $articleId]);
        }

        
        
        $redirectUrl = $_SERVER['HTTP_REFERER'] ?? "/articles";
        header("Location: $redirectUrl");
        exit;
    }
}
