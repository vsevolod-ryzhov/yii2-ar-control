<?php

declare(strict_types=1);


namespace vsevolodryzhov\yii2ArControl;


use IteratorAggregate;
use vsevolodryzhov\yii2ArControl\types\TypeInterface;

class TypeCollection implements IteratorAggregate
{
    private $items = [];

    public function add(string $attribute, TypeInterface $type): self
    {
        $this->items[$attribute] = $type;
        return $this;
    }

    public function getIterator()
    {
        return (function () {
            foreach ($this->items as $key => $val) {
                yield $key => $val;
            }
        })();
    }

    public function exists($offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function get($offset): TypeInterface
    {
        return $this->items[$offset];
    }
}