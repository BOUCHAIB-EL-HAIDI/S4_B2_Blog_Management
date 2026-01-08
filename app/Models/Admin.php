<?php
namespace Models;

class Admin extends User
{
    private string $role;

    public function __construct(int $id, string $name, string $email, string $password)
    {
        parent::__construct($id, $name, $email, $password);
        $this->role = 'admin';
    }

    public function getRole(): string
    {
        return $this->role;
    }
}