<?php



namespace Models;

abstract class User
{
    protected int $id;
    protected string $name;
    protected string $email;
    protected string $password;
    protected string $role; 

    public function __construct(int $id, string $name, string $email, string $password, string $role)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }


    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): string
    {
        return $this->role;
    }

}

?>