<?php
namespace App\Controllers;

use Core\Controller;
use Core\Database;

class CommentController extends Controller
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function addComment()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        // Allow Readers and Authors (Author extends Reader) and Admins
        error_log("CommentController: User Role is " . ($_SESSION['user_role'] ?? 'NOT SET'));

        $articleId = $_POST['article_id'] ?? null;

        if (!$articleId) {
             $_SESSION['error'] = "Article ID manquant.";
             header("Location: /articles");
             exit;
        }

        if (!in_array($_SESSION['user_role'], ['reader', 'author'])) {
            $_SESSION['error'] = "Vous n'avez pas la permission de commenter.";
            header("Location: /articles");
            exit;
        }

        $userId = $_SESSION['user_id'] ?? null;
        $content = $_POST['content'] ?? '';

        if ($userId && !empty($content)) {
            $stmt = $this->pdo->prepare("INSERT INTO comments (content, user_id, article_id, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([htmlspecialchars($content), $userId, $articleId]);
            $_SESSION['success'] = "Commentaire ajouté !";
        } else {
            $_SESSION['error'] = "Veuillez écrire un commentaire.";
        }

        // Redirect back using Referer if valid, else Articles
        $redirectUrl = $_SERVER['HTTP_REFERER'] ?? "/articles";
        header("Location: $redirectUrl");
        exit;
    }

    public function deleteComment()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        // Allow Readers and Authors
        if (!in_array($_SESSION['user_role'], ['reader', 'author'])) {
            $_SESSION['error'] = "Action non autorisée.";
            header("Location: /articles");
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: /articles");
            exit;
        }

        $userId = $_SESSION['user_id'];
        // Get the comment to check ownership
        $stmt = $this->pdo->prepare("SELECT * FROM comments WHERE id = ?");
        $stmt->execute([$id]);
        $comment = $stmt->fetch();

        if (!$comment) {
            $_SESSION['error'] = "Commentaire introuvable.";
            header('Location: /articles');
            exit;
        }

        // Check ownership (only owner can delete)
        if ($comment['user_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = "Vous n'êtes pas autorisé à supprimer ce commentaire.";
            header("Location: /article/" . $comment['article_id']);
            exit;
        }

        // Delete
        $stmt = $this->pdo->prepare("DELETE FROM comments WHERE id = ?");
        if ($stmt->execute([$id])) {
            $_SESSION['success'] = "Commentaire supprimé.";
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression.";
        }

        header("Location: /article/" . $comment['article_id']);
        exit;
    }
}
