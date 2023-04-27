<x-fab::layouts.page
    :title="$model->title ?: 'Untitled'"
    :breadcrumbs="[
            ['title' => 'Home', 'url' => route('lego.dashboard')],
            ['title' => 'Collections', 'url' => route('lego.storefront.collections.index')],
            ['title' => $model->title ?: 'Untitled'],
        ]"
    x-data=""
    x-on:keydown.meta.s.window.prevent="$wire.call('save')" {{-- For Mac --}}
    x-on:keydown.ctrl.s.window.prevent="$wire.call('save')" {{-- For PC  --}}
>
    <x-slot name="actions">
        @include('lego::models._includes.forms.page-actions')
    </x-slot>
    <x-lego::feedback.errors class="sh-mb-4" />

    <x-fab::layouts.main-with-aside>
        <x-fab::layouts.panel>
            <x-fab::forms.input
                label="Title"
                wire:model="model.title"
            />

            <x-fab::forms.input
                wire:model="model.slug"
                label="URL and handle (slug)"
                addon="{{ url('') . Route::getRoutes()->getByName('products.show')->getPrefix() . '/' }}"
                help="The URL where this collection can be viewed. Changing this will break any existing links users may have bookmarked."
                :disabled="! $model->exists"
            />

            <x-fab::forms.textarea
                wire:model="model.description"
                label="Description"
            />

            <x-fab::forms.checkbox
                id="should_index"
                label="Should be indexed"
                wire:model="model.indexable"
                help="If checked this will allow search engines (i.e. Google or Bing) to index the collection so it can be found when searching on said search engine."
            />
        </x-fab::layouts.panel>

        <x-fab::layouts.panel
            title="Products"
            description="Link products to this collection"
            class="sh-mt-4"
            allow-overflow
            x-on:fab-added="$wire.call('selectProduct', $event.detail[1].key)"
            x-on:fab-removed="$wire.call('unselectProduct', $event.detail[1].key)"
        >
            <x-fab::forms.combobox
                :items="$this->getProductsForCollectionCombobox()"
            ></x-fab::forms.combobox>

            <x-fab::lists.stacked
                    x-sortable="updateProductsOrder"
                    x-sortable.group="products"
            >
                @foreach($this->selectedProducts as $product)
                    <div
                        x-sortable.products.item="{{ $product->id }}"
                    >
                        <x-fab::lists.stacked.grouped-with-actions
                            :title="$product->title"
                            :description="$product->type"
                        >
                            <x-slot name="avatar">
                                <div class="flex">
                                    <x-fab::elements.icon icon="dots-vertical" x-sortable.products.handle class="sh-h-5 sh-w-5 sh-text-gray-300 sh--mr-2" />
                                    <x-fab::elements.icon icon="dots-vertical" x-sortable.products.handle class="sh-h-5 sh-w-5 sh-text-gray-300 sh--ml-1.5" />
                                </div>
                            </x-slot>
                            <x-slot name="actions">
                                <x-fab::elements.button
                                    size="xs"
                                    type="link"
                                    :url="route('lego.storefront.products.edit', $product)"
                                >
                                    View
                                </x-fab::elements.button>

                                <x-fab::elements.button
                                    size="xs"
                                    wire:click="unselectProduct({{ $product->id }})"
                                >
                                    Remove
                                </x-fab::elements.button>
                            </x-slot>
                        </x-fab::lists.stacked.grouped-with-actions>
                    </div>
                @endforeach
            </x-fab::lists.stacked>
        </x-fab::layouts.panel>

        <div class="sh-mt-4">
            @include('lego::metafields.define', ['metafieldable' => $model])
        </div>

        <x-slot name="aside">
            <x-fab::layouts.panel title="Structure">
                <x-fab::forms.select
                    wire:model="model.layout"
                    label="Layout"
                    help="The base layout for the page."
                >
                    <option disabled>-- Select layout</option>
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
