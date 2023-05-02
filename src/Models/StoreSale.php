<?php

namespace Astrogoat\Storefront\Models;

use Helix\Lego\Models\Model;

class StoreSale extends Model
{
    protected $table = 'storefront_sales';

    public static function icon(): string
    {
        // TODO: Implement icon() method.
    }

    public static function getDisplayKeyName() : string
    {
        return 'id';
    }

    public function order()
    {
        return $this->hasOne(StoreOrder::class, 'id', 'order_id');
    }
}
