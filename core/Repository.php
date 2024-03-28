<?php

namespace Core;

abstract class Repository
{
    /**
     * @return mixed
     */
    abstract public function all(): mixed;

    abstract public function findById(int $id);
}