<?php

namespace Src\Repositories;

use Core\Repository;
use Src\Contracts\ItemRepositoryInterface;
use Src\Entities\Item;

class ItemRepository extends Repository implements ItemRepositoryInterface
{
    private static array $DATA = [];

    public function __construct()
    {
        $this->load();
    }

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
     * @return array|mixed
     */
    public function findById(int $id)
    {
        foreach (self::$DATA as $post) {
            if ($post->id === $id) {
                return Item::fromArray((array)$post);;
            }
        }
        return [];
    }

    /**
     * Load data from db.json
     */
    private function load(): void
    {
        $DB_PATH = __DIR__ . '/../../db.json';
        self::$DATA = json_decode(file_get_contents($DB_PATH));
    }
}