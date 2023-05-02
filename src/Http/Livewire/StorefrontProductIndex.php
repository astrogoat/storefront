<?php

namespace Astrogoat\Storefront\Http\Livewire;

use Astrogoat\Storefront\Models\Product;
use Helix\Lego\Http\Livewire\Models\Index as BaseIndex;

class StorefrontProductIndex extends BaseIndex
{
    public function model(): string
    {
        return Product::class;
    }

    public function columns(): array
    {
        return [
            'title' => 'Title',
            'updated_at' => 'Last updated',
        ];
    }

    public function mainSearchColumn(): string|false
    {
        return 'title';
    }

    public function render()
    {
        return view('storefront::models.products.index', [
            'models' => $this->getModels(),
        ])->extends('lego::layouts.lego')->section('content');
    }
}
