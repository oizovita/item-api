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
            'password' =>  $auth_config['password'],
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

    /**
     * @throws Exception
     */
    public function find(int $id): User
    {
        foreach (self::$DATA as $post) {
            if ($post['id'] === $id) {
                return User::fromArray((array)$post);;
            }
        }

        throw new Exception('Item not found', 404);
    }

    /**
     * @throws Exception
     */
    public function findByEmail(string $email): User
    {
        foreach (self::$DATA as $post) {
            if ($post['email'] === $email) {
                return User::fromArray((array)$post);;
            }
        }

        throw new Exception('User not found', 404);
    }

    public function create(array $data): User
    {
        $data['id'] = count(self::$DATA) + 1;
        self::$DATA[] = $data;

        return User::fromArray($data);
    }
}