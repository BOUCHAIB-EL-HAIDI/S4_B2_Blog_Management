<?php
namespace Models;

class Like
{
    private int $id;
    private int $user_id;
    private int $article_id;

    public function __construct(int $id, int $user_id, int $article_id)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->article_id = $article_id;
    }

    public function getId(): int { return $this->id; }
    public function getUserId(): int { return $this->user_id; }
    public function getArticleId(): int { return $this->article_id; }
}