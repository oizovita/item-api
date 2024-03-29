<?php

namespace Src\Entities;

/**
 * Class Item
 * @package Src\Entities
 */
class Item
{
    public int $id;
    public string $name;

    /**
     * Item constructor.
     *
     * @param int $id The item ID.
     * @param string $name The item name.
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * Get the item ID.
     *
     * @return int The item ID.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the item name.
     *
     * @return string The item name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Create an Item object from an array.
     *
     * @param array $data The item data.
     * @return Item The Item object.
     */
    public static function fromArray(array $data): Item
    {
        return new Item($data['id'], $data['name']);
    }

    /**
     * Convert the Item object to an array.
     *
     * @return array The Item object as an array.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}