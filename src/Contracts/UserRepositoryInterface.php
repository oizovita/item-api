<?php

namespace Src\Contracts;

use Src\Entities\User;

/**
 * Interface UserRepositoryInterface
 */
interface UserRepositoryInterface
{
    /**
     * Get all items.
     *
     * @return array An array of items.
     */
    public function all(): array;

    /**
     * Find an item by its ID.
     *
     * @param int $id The ID of the item.
     * @return User|null The item if found, null otherwise.
     */
    public function find(int $id): ?User;

    /**
     * Find a user by email.
     *
     * @param string $email The email of the user.
     * @return User|null The user if found, null otherwise.
     */
    public function findByEmail(string $email): ?User;
}