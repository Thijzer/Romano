<?php

namespace Romano\Component\Common;

use Romano\Component\Common\ContainerInterface;
use Romano\Framework\Functions\ArrayFunctions as ArrayFunc;

class Matroska implements ContainerInterface
{
    private $values = [];

    public function __construct(array $values = [])
    {
        $this->addAll($values);
    }

    public function addAll(array $values): void
    {
        $this->values = array_merge($this->values, ArrayFunc::unflatten($values));
    }

    public function add(string $keys, $value): void
    {
        $this->values = array_replace_recursive($this->values, ArrayFunc::unflatten([$keys => $value]));
    }

    public function getAll(): array
    {
        return $this->values;
    }

    public static function create(array $values): Matroska
    {
        return new self($values);
    }

    public function get(...$keys)
    {
        return ArrayFunc::arrayGet($keys, $this->values);
    }

    public function remove($key): void
    {
        $this->add($key, null);
    }

    public function has(...$keys): bool
    {
        return $this->get(...$keys) !== null;
    }
}
