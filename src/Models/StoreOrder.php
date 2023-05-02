<?php

namespace Astrogoat\Storefront\Models;

use Helix\Lego\Models\Model;

class StoreOrder extends Model
{
    protected $table = 'storefront_orders';

    public static function icon(): string
    {
        // TODO: Implement icon() method.
    }

    public static function getDisplayKeyName(): string
    {
        return 'customer_name';
    }

    public function payments()
    {
        return $this->hasMany(StorePayment::class, 'order_id', 'id');
    }

    public function orderedProducts()
    {
        return $this->hasMany(StoreOrderStoreProduct::class, 'order_id', 'id');
    }
}
