<?php

namespace Src\Contracts;

use Src\Entities\User;

interface UserRepositoryInterface
{
    public function all(): array;

    public function find(int $id): ?User;

    public function findByEmail(string $email): ?User;
}