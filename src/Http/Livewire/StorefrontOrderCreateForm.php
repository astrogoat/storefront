<?php

namespace Astrogoat\Storefront\Http\Livewire;

use Astrogoat\Storefront\Models\Collection;
use Astrogoat\Storefront\Models\Product;
use Astrogoat\Storefront\Models\StoreOrder;
use Astrogoat\Storefront\Models\StoreOrderStoreProduct;
use Astrogoat\Storefront\Models\StorePayment;
use Helix\Lego\Http\Livewire\Models\Form;
use Helix\Lego\Http\Livewire\Traits\CanBePublished;
use Helix\Lego\Models\Contracts\Publishable;
use Helix\Lego\Models\Footer;
use Helix\Lego\Rules\SlugRule;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Str;

class StorefrontOrderCreateForm extends Form
{

    public SupportCollection $selectedProducts;
    public array $selectedProductsIds = [];

    public $paymentMethod;

    protected $listeners = [
        'updateProductsOrder',
    ];

    public function rules()
    {
        return [
            'model.customer_name' => 'required|min:3',
            'model.customer_email' => 'required|email',
            'model.customer_phone' => 'required|numeric',
            'model.customer_street' => 'required',
            'model.customer_city' => 'required',
            'model.customer_state' => 'required',
            'model.customer_country' => 'required',
            'model.reference' => 'required',
            'model.status' => 'required',
            'paymentMethod' => 'required',
        ];
    }

    public function mount($storeOrder = null)
    {
        $this->setModel($storeOrder);

        $this->model->reference = sprintf('%s%07s%02s',now()->format('ymd'),'o', 'n');

        $this->selectedProducts = collect([]);
    }

    public function saving()
    {
        //
    }

    public function saved() {
        // save products
        foreach($this->selectedProductsIds as $productsId) {
            StoreOrderStoreProduct::create([
               'order_id' => $this->model->id,
               'product_id' => $productsId,
                'quantity' => 1
            ]);
        }

        // save payment
        StorePayment::create([
           'status' => 'success',
            'order_id' => $this->model->id,
            'reference' => $this->model->reference . $this->model->id,
            'amount' => $this->model->orderedProducts->sum('price'),
            'method' => $this->paymentMethod,

        ]);

        // update model reference
        $this->model->reference = $this->model->reference . $this->model->id;
        $this->model->save();
    }

    public function updated($property, $value)
    {
        parent::updated($property, $value);
    }

    protected function getProductsForCollectionCombobox() : array
    {
        return Product::all()->map(fn (Product $product) => [
            'key' => $product->id,
            'value' => $product->title,
            'selected' => in_array($product->id, $this->selectedProductsIds),
        ])->toArray();
    }

    public function selectProduct($productId)
    {
        $this->selectedProductsIds[] = $productId;
        $this->selectedProducts->push(Product::find($productId));
        $this->markAsDirty();
    }

    public function unselectProduct($productId)
    {
        $this->selectedProductsIds = array_filter($this->selectedProductsIds, fn ($id) => $id !== $productId);
        $this->selectedProducts = $this->selectedProducts->reject(fn ($product) => $product['id'] === $productId);
        $this->emitTo('fab.forms.combobox', 'updateItems', $this->getProductsForCollectionCombobox());
        $this->markAsDirty();
    }

    public function updateProductsOrder($order)
    {
        $this->selectedProducts = $this->selectedProducts
            ->sort(function ($a, $b) use ($order) {
                $positionA = array_search($a->id, $order);
                $positionB = array_search($b->id, $order);

                return $positionA - $positionB;
            })
            ->values();

        $this->markAsDirty();
    }

    public function view()
    {
        return 'storefront::models.orders.create';
    }

    public function model() : string
    {
        return StoreOrder::class;
    }
}
