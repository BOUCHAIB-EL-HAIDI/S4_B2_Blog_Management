<?php
namespace Models;

use Models\Reader;

class Author extends Reader
{
    public function __construct(int $id, string $name, string $email)
    {
        parent::__construct($id, $name, $email);
        $this->role = 'author'; 
    }
    
  
}