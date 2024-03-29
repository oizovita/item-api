<?php

namespace Src\Entities;

/**
 * Class User
 */
class User
{
    private int $id;
    private string $email;
    private string $password;

    /**
     * User constructor.
     *
     * @param int $id The user ID.
     * @param string $email The user email.
     * @param string $password The user password.
     */
    public function __construct(int $id, string $email, string $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = md5($password);
    }

    /**
     * Get the user ID.
     *
     * @return int The user ID.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the user email.
     *
     * @return string The user email.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Get the user password.
     *
     * @return string The user password.
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Create a User object from an array.
     *
     * @param array $data The user data.
     * @return User The User object.
     */
    public static function fromArray(array $data): User
    {
        return new User(
            $data['id'],
            $data['email'],
            $data['password']
        );
    }

    /**
     * Convert the User object to an array.
     *
     * @return array The User object as an array.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email
        ];
    }

}