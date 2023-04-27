<?php

namespace Astrogoat\Storefront\Models;

use Helix\Lego\Models\Model;

class StoreOrderStoreProduct extends Model
{
    protected $table = 'storefront_orders_storefront_products';

    public static function icon(): string
    {
        // TODO: Implement icon() method.
    }

    public function order()
    {
        return $this->belongsTo(StoreOrder::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
