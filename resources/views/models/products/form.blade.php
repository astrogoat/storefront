<x-fab::layouts.page
    title="{{ $model->title }}"
    :breadcrumbs="[
        ['title' => 'Products', 'url' => route('lego.storefront.products.index')],
        ['title' => $model->title ?: 'Untitled'],
    ]"
    x-data=""
    x-on:keydown.meta.s.window.prevent="$wire.call('save')" {{-- For Mac --}}
    x-on:keydown.ctrl.s.window.prevent="$wire.call('save')" {{-- For PC  --}}
>
    <x-slot name="actions">
        @include('lego::models._includes.forms.page-actions')
    </x-slot>

    <x-fab::layouts.main-with-aside>
        <x-fab::layouts.panel>
            <x-fab::forms.input
                label="Product Title"
                wire:model="model.title"
            />

            <x-fab::forms.input
                wire:model.debounce.500ms="model.slug"
                label="URL and handle (slug)"
                :addon="url('') . Route::getRoutes()->getByName('products.show')->getPrefix() . '/'"
                help="The URL where this product can be viewed. Changing this will break any existing links users may have bookmarked."
                :disabled="! $model->exists"
            />
        </x-fab::layouts.panel>

        <x-fab::layouts.panel title="SEO">
            <x-fab::forms.input
                name="model.meta.page_title"
                label="Page Title"
                wire:model="model.meta.page_title"
                help="The text displayed in the browser tab/window. Will use the product title if left empty."
            />

            <x-fab::forms.textarea
                wire:model="model.meta.description"
                label="Description"
                help="Meta description for search engines like Google and Bing."
            />

            <x-fab::forms.editor
                wire:model="model.meta.features"
                label="Features/Specs"
                help="Features of the product that customers should know."
            />

            <x-fab::forms.checkbox
                id="should_index"
                label="Should be indexed"
                wire:model="model.indexable"
                help="If checked this will allow search engines (i.e. Google or Bing) to index the product so it can be found when searching on said search engine."
            />

        </x-fab::layouts.panel>

        <x-fab::layouts.panel title="PRICING">
            <x-fab::forms.input
                label="Product Amount ($)"
                wire:model="model.price"
                help="The amount this product would be sold for."
            />
        </x-fab::layouts.panel>

        @include('lego::metafields.define', ['metafieldable' => $model])

        <x-slot name="aside">
            <x-fab::layouts.panel title="Structure">
                <x-fab::forms.select
                    wire:model="model.layout"
                    label="Layout"
                    help="The base layout for the model."
                >
                    <option disabled>-- Select layout</option>
                    <option value="">Default</option>
                    @foreach(siteLayouts() as $key => $layout)
                        <option value="{{ $key }}">{{ $layout }}</option>
                    @endforeach
                </x-fab::forms.select>

                <x-fab::forms.select
                    wire:model="model.footer_id"
                    label="Footer"
                >
                    <option value="">No footer</option>
                    @foreach($this->footers() as $id => $footer)
                        <option value="{{ $id }}">{{ $footer }}</option>
                    @endforeach
                </x-fab::forms.select>
            </x-fab::layouts.panel>

            <x-lego::media-panel :model="$model" />

        </x-slot>
    </x-fab::layouts.main-with-aside>

</x-fab::layouts.page>

@push('styles')
    <link href="{{ asset('vendor/storefront/css/storefront.css') }}" rel="stylesheet">
@endpush
