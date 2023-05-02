<?php

namespace Astrogoat\Storefront\Bricks;

use Helix\Lego\Bricks\Brick;
use Helix\Lego\Bricks\ValueObjects\BrickValueObject;

class Collection extends Brick
{
    public function hydrate($value): BrickValueObject
    {
        return new CollectionValueObject($value);
    }

    public function getDefaults()
    {
        return $this->default;
    }

    public function brickView(): string
    {
        return 'shopify::bricks.collection';
    }
}
