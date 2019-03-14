<?php

namespace Romano\Component\Common\Model;

class Collection implements \Countable, \IteratorAggregate
{
    private $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function add($item)
    {
        $this->items[] = $item;
    }

    public function each(callable $callback): void
    {
        foreach ($this->items as $key => $item) {
            if (false === $callback($item, $key)) {
                break;
            }
        }
    }

    public function filter(callable $callback): self
    {
        return new self(array_filter($this->items, $callback));
    }

    public function map(callable $callback): self
    {
        $keys = array_keys($this->items);
        $items = array_map($callback, $this->items, $keys);

        return new self(array_combine($keys, $items));
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    public function hasItems(): bool
    {
        return $this->count() > 0;
    }

    public function count(): int
    {
        return \count($this->items);
    }

    public function current()
    {
        return current($this->items);
    }

    public function end()
    {
        return end($this->items);
    }
}
