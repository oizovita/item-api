<?php

namespace Src\Repositories;

use Core\Config;
use Exception;
use Src\Contracts\UserRepositoryInterface;
use Src\Entities\User;

/**
 * Class UserRepository
 */
class UserRepository implements UserRepositoryInterface
{

    private static array $DATA = [
    ];

    /**
     * UserRepository constructor.
     */
    public function __construct()
    {
        $auth_config = Config::get('auth');
        static::$DATA[] = [
            'id' => 1,
            'email' => $auth_config['email'],
            'password' => $auth_config['password'],
        ];
    }

    /**
     * Get all users.
     *
     * @return array An array of users.
     */
    public function all(): array
    {
        return array_map(function ($data) {
            return User::fromArray((array)$data);
        }, self::$DATA);
    }


    /**
     * Find a user by its ID.
     *
     * @param int $id The ID of the user.
     * @return User|null The user if found, null otherwise.
     */
    public function find(int $id): ?User
    {
        $data = array_filter(self::$DATA, function ($users) use ($id) {
            return $users['id'] === $id;
        });

        if (empty($data)) return null;

        return User::fromArray($data);
    }

    /**
     * Find a user by email.
     *
     * @param string $email The email of the user.
     * @return User|null The user if found, null otherwise.
     */
    public function findByEmail(string $email): ?User
    {
        $data = array_filter(self::$DATA, function ($users) use ($email) {
            return $users['email'] === $email;
        });

        if (empty($data)) return null;

        return User::fromArray($data);
    }
}