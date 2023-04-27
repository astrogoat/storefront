<?php

namespace Astrogoat\Storefront\Http\Livewire;

use Astrogoat\Storefront\Models\Collection;
use Astrogoat\Storefront\Models\Product;
use Helix\Lego\Http\Livewire\Models\Form;
use Helix\Lego\Http\Livewire\Traits\CanBePublished;
use Helix\Lego\Models\Contracts\Publishable;
use Helix\Lego\Models\Footer;
use Helix\Lego\Rules\SlugRule;
use Illuminate\Support\Collection as SupportCollection;

class StorefrontCollectionForm extends Form
{
    use CanBePublished;

    public SupportCollection $selectedProducts;
    public array $selectedProductsIds = [];

    protected $listeners = [
        'updateProductsOrder',
    ];

    public function rules()
    {
        return [
            'model.title' => 'required',
            'model.slug' => [new SlugRule($this->model)],
            'model.description' => 'nullable',
            'model.indexable' => 'nullable',
            'model.layout' => 'nullable',
            'model.footer_id' => 'nullable',
            'metafields.*.value' => 'nullable',
            'model.published_at' => 'nullable',
        ];
    }

    public function mount($collection = null)
    {
        $this->setModel($collection);

        if (! $this->model->exists) {
            $this->model->indexable = true;
            $this->model->layout = array_key_first(siteLayouts());
        }

        $this->selectedProducts = $this->model->products;
        $this->selectedProductsIds = $this->selectedProducts->map(fn ($product) => $product->id)->toArray();
    }

    public function saving()
    {
        $this->model->products()->sync(
            $this->selectedProducts->mapWithKeys(fn ($product, $index) => [$product->id => ['order' => $index]])
        );
    }

    public function updated($property, $value)
    {
        parent::updated($property, $value);

        if ($property == 'model.footer_id' && ! $value) {
            $this->model->footer_id = null;
        }
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
        $this->selectedProducts = $this->selectedProducts->reject(fn ($product) => $product->id === $productId);
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
        return 'storefront::models.collections.form';
    }

    public function model() : string
    {
        return Collection::class;
    }

    public function footers()
    {
        return Footer::all()->pluck('title', 'id');
    }

    public function getPublishableModel() : Publishable
    {
        return $this->model;
    }
}
