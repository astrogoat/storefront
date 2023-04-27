<?php

namespace Astrogoat\Storefront\Http\Livewire;

use Astrogoat\Storefront\Models\StoreOrder;
use Helix\Lego\Http\Livewire\Models\Form;

class StorefrontOrderForm extends Form
{
    public function rules()
    {
        return [
            //
        ];
    }

    public function mount($storeOrder = null)
    {
        $this->setModel($storeOrder);

        if (! $this->model->exists) {
            $this->model->indexable = true;
            $this->model->layout = array_key_first(siteLayouts());
        }
    }

    public function saving()
    {
        //
    }

    public function updated($property, $value)
    {
        parent::updated($property, $value);
    }

    public function view()
    {
        return 'storefront::models.orders.form';
    }

    public function model(): string
    {
        return StoreOrder::class;
    }
}
