<?php

declare(strict_types=1);


namespace vsevolodryzhov\yii2ArControl;


use IteratorAggregate;
use vsevolodryzhov\yii2ArControl\types\InvalidTypeClass;
use vsevolodryzhov\yii2ArControl\types\TypeInterface;

class TypeCollection implements IteratorAggregate
{
    private $items = [];

    /**
     * @param string $attribute
     * @param string $className
     * @param array $options
     * @return $this
     */
    public function add(string $attribute, string $className, array $options = []): self
    {
        if (!class_exists($className)) {
            throw new InvalidTypeClass("$className not found");
        }
        if (!in_array(TypeInterface::class, class_implements($className), true)) {
            throw new InvalidTypeClass("$className must implement " . TypeInterface::class);
        }
        $this->items[$attribute] = new $className($options);
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