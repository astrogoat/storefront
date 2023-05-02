<?php

namespace Astrogoat\Storefront\Http\Livewire;

use Astrogoat\Storefront\Models\Collection;
use Helix\Lego\Http\Livewire\Models\Index as BaseIndex;

class StorefrontCollectionIndex extends BaseIndex
{
    public function model(): string
    {
        return Collection::class;
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
        return view('storefront::models.collections.index', [
            'models' => $this->getModels(),
        ])->extends('lego::layouts.lego')->section('content');
    }
}
