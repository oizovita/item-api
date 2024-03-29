<?php

namespace Src\Repositories;

use Src\Contracts\ItemRepositoryInterface;
use Src\Entities\Item;

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
     * @return array
     */
    public function all(): array
    {
        return array_map(function ($data) {
            return Item::fromArray((array)$data);
        }, self::$DATA);
    }

    /**
     * @param int $id
     * @return Item|null
     */
    public function find(int $id): ?Item
    {

        $data = array_filter(self::$DATA, function ($items) use ($id) {
            return $items['id'] === $id;
        });

        if (empty($data)) return null;

        return Item::fromArray($data);
    }
}