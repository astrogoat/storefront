<?php

namespace Astrogoat\Storefront\Http\Livewire;

use Astrogoat\Storefront\Models\StoreOrder;
use Astrogoat\Storefront\Models\StoreSale;
use Helix\Lego\Http\Livewire\Models\Form;

class StorefrontOrderForm extends Form
{
    public function rules()
    {
        return [
            'model.status' => 'required',
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
        if($this->model->status === 'delivered') {
            // check if a sale already exists with order id
            // if not, create one, it exists; ignore.
            $sale = StoreSale::where('order_id', $this->model->id)->first();
            if(is_null($sale)) {
                StoreSale::create([
                    'order_id' => $this->model->id,
                ]);
            }
        }
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

    public function hasCompletedPayment()
    {
        $payments = $this->model->payments;
        if(is_null($payments)) {
            return false;
        }

        return $payments?->first()?->status === 'success';
    }
}
