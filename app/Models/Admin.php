<?php
namespace Models;
use Models\User;
class Admin extends User
{
    public function __construct(int $id, string $name, string $email, string $password)
    {
        parent::__construct($id, $name, $email, $password, 'admin');
    }

}