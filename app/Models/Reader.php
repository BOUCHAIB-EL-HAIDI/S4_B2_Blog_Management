<?php
namespace Models;

use Models\User;

class Reader extends User
{
    protected string $role;

    public function __construct(int $id, string $name, string $email)
    {
        parent::__construct($id, $name, $email);
        $this->role = 'reader'; 
    }

    public function getRole(): string
    {
        return $this->role;
    }
}