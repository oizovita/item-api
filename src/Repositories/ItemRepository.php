<?php

namespace Src\Repositories;

use Src\Contracts\ItemRepositoryInterface;
use Src\Entities\Item;

/**
 * Class ItemRepository
 */
class ItemRepository implements ItemRepositoryInterface
{
    private static array $DATA = [
        ['id' => 1, 'name' => 'Item 1'],
        ['id' => 2, 'name' => 'Item 2'],
        ['id' => 3, 'name' => 'Item 3'],
        ['id' => 4, 'name' => 'Item 4'],
        ['id' => 5, 'name' => 'Item 5'],
    ];

    /**
     * Get all items.
     *
     * @return array An array of items.
     */
    public function all(): array
    {
        return array_map(function ($data) {
            return Item::fromArray((array)$data);
        }, self::$DATA);
    }

    /**
     * Find an item by its ID.
     *
     * @param int $id The ID of the item.
     * @return Item|null The item if found, null otherwise.
     */
    public function find(int $id): ?Item
    {
        foreach (self::$DATA as $data) {
            if ($data['id'] === $id) {
                return Item::fromArray($data);
            }
        }
        return null;
    }
}