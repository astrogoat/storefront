<x-fab::layouts.page
    title="Products"
    :breadcrumbs="[
        ['title' => 'Home', 'url' => route('lego.dashboard')],
        ['title' => 'Products','url' => route('lego.storefront.products.index')],
    ]"
    x-data="{ showColumnFilters: false }"
>
    <x-slot name="actions">
        <x-fab::elements.button type="link" :url="route('lego.storefront.products.create')">Create</x-fab::elements.button>
    </x-slot>
    @include('lego::models._includes.indexes.filters')

    <x-fab::lists.table>
        <x-slot name="headers">
            @include('lego::models._includes.indexes.headers')
            <x-fab::lists.table.header :hidden="true">Edit</x-fab::lists.table.header>
            <x-fab::lists.table.header :hidden="true">Customize</x-fab::lists.table.header>
        </x-slot>

        @include('lego::models._includes.indexes.header-filters')
        <x-fab::lists.table.header x-show="showColumnFilters" x-cloak class="bg-gray-100" />
        <x-fab::lists.table.header x-show="showColumnFilters" x-cloak class="bg-gray-100" />

        @foreach($models as $product)
            <x-fab::lists.table.row :odd="$loop->odd">
                @if($this->shouldShowColumn('title'))
                    <x-fab::lists.table.column primary full>
                        <a href="{{ route('lego.storefront.products.edit', $product) }}">{{ $product->title }}</a>
                    </x-fab::lists.table.column>
                @endif

                @if($this->shouldShowColumn('published_at'))
                    <x-fab::lists.table.column>
                        {{ $product->publishedState() }}
                    </x-fab::lists.table.column>
                @endif

                @if($this->shouldShowColumn('indexable'))
                    <x-fab::lists.table.column>
                        {{ $product->indexable ? 'Yes' : 'No' }}
                    </x-fab::lists.table.column>
                @endif

                @if($this->shouldShowColumn('updated_at'))
                    <x-fab::lists.table.column align="right">
                        {{ $product->updated_at->toFormattedDateString() }}
                    </x-fab::lists.table.column>
                @endisset

                <x-fab::lists.table.column align="right" slim>
                    <a href="{{ route('lego.storefront.products.edit', $product) }}">Edit</a>
                </x-fab::lists.table.column>

                <x-fab::lists.table.column align="right" slim>
                    <a href="{{ route('lego.storefront.products.editor', $product) }}">Customize</a>
                </x-fab::lists.table.column>
            </x-fab::lists.table.row>
        @endforeach
    </x-fab::lists.table>

    @include('lego::models._includes.indexes.pagination')
</x-fab::layouts.page>
