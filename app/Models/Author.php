<?php
namespace App\Models;

class Author extends Reader
{
    private string $role;

    public function __construct(int $id, string $name, string $email, string $password)
    {
        parent::__construct($id, $name, $email, $password);
        $this->role = 'author';
    }

    public function getRole(): string
    {
        return $this->role;
    }
}
