<?php

namespace Astrogoat\Storefront\Models;

use Helix\Lego\Models\Model;

class StorePayment extends Model
{
    protected $table = 'storefront_payments';

    public static function icon(): string
    {
        // TODO: Implement icon() method.
    }

    public function Order()
    {
        return $this->belongsTo(StoreOrder::class, 'order_id');
    }
}
