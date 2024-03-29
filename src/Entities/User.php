<?php

namespace Src\Entities;

/**
 * Class User
 * @package Src\Entities
 */
class User
{
    private int $id;
    private string $email;
    private string $password;

    public function __construct(int $id, string $email, string $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = md5($password);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }


    public static function fromArray(array $data): User
    {
        return new User(
            $data['id'],
            $data['email'],
            $data['password']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email
        ];
    }

}