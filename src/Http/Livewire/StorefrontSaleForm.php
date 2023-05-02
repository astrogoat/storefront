<?php

namespace Astrogoat\Storefront\Http\Livewire;

use Astrogoat\Storefront\Models\StoreSale;
use Helix\Lego\Http\Livewire\Models\Form;

class StorefrontSaleForm extends Form
{
    //    public $status;

    public function rules()
    {
        return [
            'model.order.status' => 'required',
        ];
    }

    public function mount($storeSale = null)
    {
        $this->setModel($storeSale);

        if (! $this->model->exists) {
            $this->model->indexable = true;
            $this->model->layout = array_key_first(siteLayouts());
        }

        $this->status = $this->model->order->status;
    }

    public function saving()
    {
        $sale = StoreSale::where('order_id', $this->model->order->id)->first();
        $sale->delete();
    }

    public function updated($property, $value)
    {
        parent::updated($property, $value);
    }

    public function view()
    {
        return 'storefront::models.sales.form';
    }

    public function model(): string
    {
        return StoreSale::class;
    }

    public function hasCompletedPayment()
    {
        $payments = $this->model->payments;
        if(is_null($payments)) {
            return false;
        }

        return $payments->first()->status === 'success';
    }
}
