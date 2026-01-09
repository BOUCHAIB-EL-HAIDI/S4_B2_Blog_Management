<?php



namespace Models;

abstract class User
{
    protected int $id;
    protected string $name;
    protected string $email;
    protected string $password;
    public function __construct(int $id, string $name, string $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
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


    abstract public function getRole(): string;
}

?>