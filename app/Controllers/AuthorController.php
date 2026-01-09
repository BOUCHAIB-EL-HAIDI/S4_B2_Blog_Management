<?php
namespace App\Controllers;

use Core\Controller;
use Core\Database;

class AuthorController extends Controller
{
    private $pdo;
    
    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }
    
    private function checkAuthorAccess()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'author') {
            $_SESSION['error'] = "Accès non autorisé";
            header('Location: /');
            exit;
        }
    }
    
    public function dashboard()
    {
        $this->checkAuthorAccess();
        
        $authorId = $_SESSION['user_id'];
        
        // Get statistics
        $stats = $this->getAuthorStats($authorId);
        
        // Get author's articles with likes and comments count
        $articles = $this->getAuthorArticles($authorId);
        
        $this->view('author/dashboard', [
            'title' => 'Dashboard Auteur - MyBlog',
            'stats' => $stats,
            'articles' => $articles
        ]);
    }
    
    private function getAuthorStats($authorId)
    {
        // Total articles
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM articles WHERE author_id = ?");
        $stmt->execute([$authorId]);
        $totalArticles = $stmt->fetch()['total'];
        
        // Total likes
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) as total 
            FROM likes l
            JOIN articles a ON l.article_id = a.id
            WHERE a.author_id = ?
        ");
        $stmt->execute([$authorId]);
        $totalLikes = $stmt->fetch()['total'];
        
        // Total comments
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) as total 
            FROM comments c
            JOIN articles a ON c.article_id = a.id
            WHERE a.author_id = ?
        ");
        $stmt->execute([$authorId]);
        $totalComments = $stmt->fetch()['total'];
        
        return [
            'total_articles' => $totalArticles,
            'total_likes' => $totalLikes,
            'total_comments' => $totalComments,
            'total_views' => 0 // You can implement views tracking later
        ];
    }
    
    private function getAuthorArticles($authorId)
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                a.id,
                a.title,
                a.content,
                a.created_at,
                COUNT(DISTINCT l.id) as likes_count,
                COUNT(DISTINCT c.id) as comments_count
            FROM articles a
            LEFT JOIN likes l ON a.id = l.article_id
            LEFT JOIN comments c ON a.id = c.article_id
            WHERE a.author_id = ?
            GROUP BY a.id
            ORDER BY a.created_at DESC
        ");
        $stmt->execute([$authorId]);
        $articles = $stmt->fetchAll();
        
        // Get categories for each article
        foreach ($articles as &$article) {
            $stmt = $this->pdo->prepare("
                SELECT c.name
                FROM categories c
                JOIN article_category ac ON c.id = ac.category_id
                WHERE ac.article_id = ?
            ");
            $stmt->execute([$article['id']]);
            $article['categories'] = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        }
        
        return $articles;
    }
    
    public function create()
    {
        $this->checkAuthorAccess();
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $categories = $this->getAllCategories();
            
            $this->view('author/create', [
                'title' => 'Créer un Article - MyBlog',
                'categories' => $categories,
                'old' => $_SESSION['old'] ?? [],
                'errors' => $_SESSION['errors'] ?? []
            ]);
            
            unset($_SESSION['old'], $_SESSION['errors']);
            return;
        }
        
        // POST - Create article
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $categories = $_POST['categories'] ?? [];
        
        $errors = [];
        
        if (empty($title)) {
            $errors[] = "Le titre est obligatoire";
        }
        
        if (empty($content)) {
            $errors[] = "Le contenu est obligatoire";
        }
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header('Location: /author/articles/create');
            exit;
        }
        
        try {
            $this->pdo->beginTransaction();
            
            // Insert article
            $stmt = $this->pdo->prepare("
                INSERT INTO articles (title, content, author_id, created_at)
                VALUES (?, ?, ?, NOW())
            ");
            $stmt->execute([$title, $content, $_SESSION['user_id']]);
            $articleId = $this->pdo->lastInsertId();
            
            // Insert categories
            if (!empty($categories)) {
                $stmt = $this->pdo->prepare("
                    INSERT INTO article_category (article_id, category_id)
                    VALUES (?, ?)
                ");
                foreach ($categories as $categoryId) {
                    $stmt->execute([$articleId, $categoryId]);
                }
            }
            
            $this->pdo->commit();
            
            $_SESSION['success'] = "Article créé avec succès!";
            header('Location: /author/dashboard');
            exit;
            
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            $_SESSION['error'] = "Erreur lors de la création de l'article";
            header('Location: /author/articles/create');
            exit;
        }
    }
    
    public function edit($id)
    {
        $this->checkAuthorAccess();
        
        // Get article and verify ownership
        $article = $this->getArticleById($id);
        
        if (!$article || $article['author_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = "Article non trouvé ou accès non autorisé";
            header('Location: /author/dashboard');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $allCategories = $this->getAllCategories();
            $articleCategories = $this->getArticleCategories($id);
            
            $this->view('author/edit', [
                'title' => 'Modifier l\'Article - MyBlog',
                'article' => $article,
                'all_categories' => $allCategories,
                'article_categories' => $articleCategories,
                'errors' => $_SESSION['errors'] ?? []
            ]);
            
            unset($_SESSION['errors']);
            return;
        }
        
        // POST - Update article
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $categories = $_POST['categories'] ?? [];
        
        $errors = [];
        
        if (empty($title)) {
            $errors[] = "Le titre est obligatoire";
        }
        
        if (empty($content)) {
            $errors[] = "Le contenu est obligatoire";
        }
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: /author/articles/edit/' . $id);
            exit;
        }
        
        try {
            $this->pdo->beginTransaction();
            
            // Update article
            $stmt = $this->pdo->prepare("
                UPDATE articles 
                SET title = ?, content = ?
                WHERE id = ? AND author_id = ?
            ");
            $stmt->execute([$title, $content, $id, $_SESSION['user_id']]);
            
            // Delete old categories
            $stmt = $this->pdo->prepare("DELETE FROM article_category WHERE article_id = ?");
            $stmt->execute([$id]);
            
            // Insert new categories
            if (!empty($categories)) {
                $stmt = $this->pdo->prepare("
                    INSERT INTO article_category (article_id, category_id)
                    VALUES (?, ?)
                ");
                foreach ($categories as $categoryId) {
                    $stmt->execute([$id, $categoryId]);
                }
            }
            
            $this->pdo->commit();
            
            $_SESSION['success'] = "Article mis à jour avec succès!";
            header('Location: /author/dashboard');
            exit;
            
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            $_SESSION['error'] = "Erreur lors de la mise à jour de l'article";
            header('Location: /author/articles/edit/' . $id);
            exit;
        }
    }
    
    public function delete($id)
    {
        $this->checkAuthorAccess();
        
        // Verify ownership
        $stmt = $this->pdo->prepare("SELECT author_id FROM articles WHERE id = ?");
        $stmt->execute([$id]);
        $article = $stmt->fetch();
        
        if (!$article || $article['author_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = "Article non trouvé ou accès non autorisé";
            header('Location: /author/dashboard');
            exit;
        }
        
        try {
            $stmt = $this->pdo->prepare("DELETE FROM articles WHERE id = ? AND author_id = ?");
            $stmt->execute([$id, $_SESSION['user_id']]);
            
            $_SESSION['success'] = "Article supprimé avec succès";
        } catch (\Exception $e) {
            $_SESSION['error'] = "Erreur lors de la suppression de l'article";
        }
        
        header('Location: /author/dashboard');
        exit;
    }
    
    private function getAllCategories()
    {
        $stmt = $this->pdo->query("SELECT id, name FROM categories ORDER BY name");
        return $stmt->fetchAll();
    }
    
    private function getArticleById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM articles WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    private function getArticleCategories($articleId)
    {
        $stmt = $this->pdo->prepare("
            SELECT category_id 
            FROM article_category 
            WHERE article_id = ?
        ");
        $stmt->execute([$articleId]);
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }
}