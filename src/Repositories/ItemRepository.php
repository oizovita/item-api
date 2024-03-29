<?php

namespace Src\Repositories;

use Exception;
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
     * @return Item
     * @throws Exception
     */
    public function find(int $id): Item
    {
        foreach (self::$DATA as $post) {
            if ($post['id'] === $id) {
                return Item::fromArray((array)$post);;
            }
        }

        throw new Exception('Item not found', 404);
    }
}