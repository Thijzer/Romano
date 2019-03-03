<?php

namespace Romano\Framework;

interface ContainerInterface
{
    /**
     * Returns a result based from the key
     *
     * @param array ...$keys
     *
     * @return mixed
     */
    public function get(...$keys);
    public function getAll(): array;

    /**
     * Multi dimensional key support
     *
     * @param array ...$keys
     *
     * @return bool
     */
    public function has(...$keys): bool;

    /**
     * Set any value based on multi dimensional key
     * @param string $keys
     * @param $value
     */
    public function add(string $keys, $value): void;
    public function addAll(array $values): void;

    /**
     * @param string $key
     */
    public function remove(string $key): void;
}
