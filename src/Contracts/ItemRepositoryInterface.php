<?php

namespace Src\Contracts;

use Src\Entities\Item;

/**
 * Interface ItemRepositoryInterface
 */
interface ItemRepositoryInterface
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
     * @return Item|null The item if found, null otherwise.
     */
    public function find(int $id): ?Item;
}