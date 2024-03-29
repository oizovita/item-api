<?php

namespace Src\Repositories;

use Core\Config;
use Exception;
use Src\Contracts\UserRepositoryInterface;
use Src\Entities\User;

class UserRepository implements UserRepositoryInterface
{

    private static array $DATA = [
    ];

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
     * @return array
     */
    public function all(): array
    {
        return array_map(function ($data) {
            return User::fromArray((array)$data);
        }, self::$DATA);
    }


    public function find(int $id): ?User
    {
        $data = array_filter(self::$DATA, function ($users) use ($id) {
            return $users['id'] === $id;
        });

        if (empty($data)) return null;

        return User::fromArray($data);
    }

    /**
     * @throws Exception
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