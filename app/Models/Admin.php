<?php
namespace Models;
use Models\User;
class Admin extends User
{
    private string $role;

    public function __construct(int $id, string $name, string $email)
    {
        parent::__construct($id, $name, $email);
        $this->role = 'admin';
    }

    public function getRole(): string
    {
        return $this->role;
    }
}