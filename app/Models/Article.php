<?php
namespace Models;

class Article
{
    private int $id;
    private string $title;
    private string $content;
    private int $author_id;
    private string $created_at;

    public function __construct(int $id, string $title, string $content, int $author_id, string $created_at)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->author_id = $author_id;
        $this->created_at = $created_at;
    }

    public function getId(): int { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function getContent(): string { return $this->content; }
    public function getAuthorId(): int { return $this->author_id; }
    public function getCreatedAt(): string { return $this->created_at; }
}
