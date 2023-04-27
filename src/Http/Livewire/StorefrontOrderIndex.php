<?php

namespace Astrogoat\Storefront\Http\Livewire;

use Astrogoat\Storefront\Models\StoreOrder;
use Helix\Lego\Http\Livewire\Models\Index as BaseIndex;

class StorefrontOrderIndex extends BaseIndex
{
    public function model(): string
    {
        return StoreOrder::class;
    }

    public function columns(): array
    {
        return [
            'reference' => 'Reference',
            'customer_name' => 'Customer name',
            'customer_phone' => 'Phone',
            'customer_country' => 'Country',
            'updated_at' => 'Last updated',
        ];
    }

    public function mainSearchColumn(): string|false
    {
        return 'customer_name';
    }

    public function render()
    {
        return view('storefront::models.orders.index', [
            'models' => $this->getModels(),
        ])->extends('lego::layouts.lego')->section('content');
    }
}
