<?php
namespace Models;

use Models\Reader;

class Author extends Reader
{
    public function __construct(int $id, string $name, string $email, string $password)
    {
        parent::__construct($id, $name, $email, $password);
        $this->role = 'author'; 
    }
    
}