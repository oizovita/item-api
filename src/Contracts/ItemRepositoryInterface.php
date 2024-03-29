<?php

namespace Src\Contracts;

use Src\Entities\Item;

interface ItemRepositoryInterface
{
    public function all(): array;

    public function find(int $id): ?Item;
}