<?php
namespace App\Controllers;

use Core\Controller;
use Core\Database;

class ArticleController extends Controller
{
    private $pdo;
    
    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }
    
    public function index()
    {
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        if (($_SESSION['user_role'] ?? '') === 'admin') {
            header('Location: /admin/dashboard');
            exit;
        }

        $categoryFilter = $_GET['category'] ?? null;
        
        
        $categories = $this->getAllCategories();
        
        
        if ($categoryFilter) {
            $articles = $this->getArticlesByCategory($categoryFilter);
        } else {
            $articles = $this->getAllArticles();
        }
        
        $this->view('articles', [
            'title' => 'Tous les Articles - MyBlog',
            'articles' => $articles,
            'categories' => $categories
        ]);
    }
    

    
    private function getAllCategories()
    {
        $stmt = $this->pdo->query("SELECT * FROM categories ORDER BY name");
        return $stmt->fetchAll();
    }
    

    
    private function getAllArticles()
    {
        $stmt = $this->pdo->query("
            SELECT 
                a.id,
                a.title,
                a.content,
                a.created_at,
                u.name as author_name,
                COUNT(DISTINCT l.id) as likes_count,
                COUNT(DISTINCT c.id) as comments_count
            FROM articles a
            JOIN users u ON a.author_id = u.id
            LEFT JOIN likes l ON a.id = l.article_id
            LEFT JOIN comments c ON a.id = c.article_id
            GROUP BY a.id
            ORDER BY a.created_at DESC
        ");
        $articles = $stmt->fetchAll();
        
        foreach ($articles as &$article) {
            $article['categories'] = $this->getArticleCategoryNames($article['id']);
            $article['user_has_liked'] = $this->hasUserLiked($article['id']);
            $article['comments'] = $this->getArticleComments($article['id']);
        }
        
        return $articles;
    }
    
    private function getArticlesByCategory($categoryId)
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                a.id,
                a.title,
                a.content,
                a.created_at,
                u.name as author_name,
                COUNT(DISTINCT l.id) as likes_count,
                COUNT(DISTINCT c.id) as comments_count
            FROM articles a
            JOIN users u ON a.author_id = u.id
            JOIN article_category ac ON a.id = ac.article_id
            LEFT JOIN likes l ON a.id = l.article_id
            LEFT JOIN comments c ON a.id = c.article_id
            WHERE ac.category_id = ?
            GROUP BY a.id
            ORDER BY a.created_at DESC
        ");
        $stmt->execute([$categoryId]);
        $articles = $stmt->fetchAll();
        
        foreach ($articles as &$article) {
            $article['categories'] = $this->getArticleCategoryNames($article['id']);
            $article['user_has_liked'] = $this->hasUserLiked($article['id']);
            $article['comments'] = $this->getArticleComments($article['id']);
        }
        
        return $articles;
    }
    
    private function getArticleWithDetails($id)
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                a.*,
                u.name as author_name,
                u.email as author_email,
                COUNT(DISTINCT l.id) as likes_count,
                COUNT(DISTINCT c.id) as comments_count
            FROM articles a
            JOIN users u ON a.author_id = u.id
            LEFT JOIN likes l ON a.id = l.article_id
            LEFT JOIN comments c ON a.id = c.article_id
            WHERE a.id = ?
            GROUP BY a.id
        ");
        $stmt->execute([$id]);
        $article = $stmt->fetch();
        
        if ($article) {
            $article['categories'] = $this->getArticleCategoryNames($id);
        }
        
        return $article;
    }
    
    private function getArticleComments($articleId)
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                c.*,
                u.name as user_name
            FROM comments c
            JOIN users u ON c.user_id = u.id
            WHERE c.article_id = ?
            ORDER BY c.created_at DESC
        ");
        $stmt->execute([$articleId]);
        return $stmt->fetchAll();
    }
    
    private function hasUserLiked($articleId)
    {
        if (!isset($_SESSION['user_id'])) {
            return false;
        }
        
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) as count 
            FROM likes 
            WHERE article_id = ? AND user_id = ?
        ");
        $stmt->execute([$articleId, $_SESSION['user_id']]);
        return $stmt->fetch()['count'] > 0;
    }
    
    private function getArticleCategoryNames($articleId)
    {
        $stmt = $this->pdo->prepare("
            SELECT c.name
            FROM categories c
            JOIN article_category ac ON c.id = ac.category_id
            WHERE ac.article_id = ?
        ");
        $stmt->execute([$articleId]);
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }
}