<?php

namespace Astrogoat\Storefront\Bricks;

use Helix\Lego\Bricks\ValueObjects\BrickValueObject;

class CollectionValueObject extends BrickValueObject
{
    protected $cache = [];

    public function __construct(protected $value)
    {
    }

    public function getCollection(): \Astrogoat\Storefront\Models\Collection|null
    {
        if (isset($this->cache[$this->value])) {
            return $this->cache[$this->value];
        }

        $this->cache[$this->value] = \Astrogoat\Storefront\Models\Collection::find($this->value);

        return $this->cache[$this->value];
    }

    public function getValue()
    {
        return $this->value;
    }

    public function forJavascript()
    {
        return $this->getValue() ?? '';
    }

    public function __toString()
    {
        return '';
    }

    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }
}
