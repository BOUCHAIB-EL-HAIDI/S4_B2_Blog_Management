<?php
namespace Models;

use Models\User;

class Reader extends User
{
    protected string $role;

    public function __construct(int $id, string $name, string $email, string $password)
    {
        parent::__construct($id, $name, $email, $password, 'reader');
    }

}








