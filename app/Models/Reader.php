<?php
namespace Models;

class Reader extends User
{
private string $role ;

public function __construct($id ,$name , $email , $password ){

parent::__construct($id , $name , $email , $password);
$this->role = 'author';

}

public function getRole(){

    return $this->role;
}


}