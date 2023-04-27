<?php

namespace Astrogoat\Storefront\Http\Livewire;

use Astrogoat\Storefront\Models\Product;
use Helix\Lego\Http\Livewire\Models\Form;
use Helix\Lego\Http\Livewire\Traits\CanBePublished;
use Helix\Lego\Models\Contracts\Publishable;
use Helix\Lego\Models\Footer;
use Helix\Lego\Rules\SlugRule;

class StorefrontProductForm extends Form
{
    use CanBePublished;

    public function rules()
    {
        return [
            'model.title' => 'required',
            'model.slug' => [new SlugRule($this->model)],
            'model.meta.page_title' => 'nullable',
            'model.meta.description' => 'nullable',
            'model.meta.features' => 'nullable',
            'model.price' => 'nullable',
            'model.indexable' => 'nullable',
            'model.layout' => 'nullable',
            'model.footer_id' => 'nullable',
            'metafields.*.value' => 'nullable',
            'model.published_at' => 'nullable',
        ];
    }

    public function mount($product = null)
    {
        $this->setModel($product);

        if (! $this->model->exists) {
            $this->model->price = 0;
            $this->model->indexable = true;
            $this->model->layout = array_key_first(siteLayouts());
        }
    }

    public function updated($property, $value)
    {
        parent::updated($property, $value);

        if ($property == 'model.footer_id' && ! $value) {
            $this->model->footer_id = null;
        }
    }

    public function view()
    {
        return 'storefront::models.products.form';
    }

    public function model(): string
    {
        return Product::class;
    }

    public function footers()
    {
        return Footer::all()->pluck('title', 'id');
    }

    public function getPublishableModel(): Publishable
    {
        return $this->model;
    }
}
