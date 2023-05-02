<x-fab::layouts.page
    title="Sales"
    :breadcrumbs="[
        ['title' => 'Home', 'url' => route('lego.dashboard')],
        ['title' => 'Sales','url' => route('lego.storefront.sales.index')],
    ]"
    x-data="{ showColumnFilters: true }"
>

    @include('lego::models._includes.indexes.filters')

    <x-fab::lists.table>
        <x-slot name="headers">
            @include('lego::models._includes.indexes.headers')
            <x-fab::lists.table.header :hidden="true">Edit</x-fab::lists.table.header>
        </x-slot>

        @include('lego::models._includes.indexes.header-filters')
        <x-fab::lists.table.header x-show="showColumnFilters" x-cloak class="bg-gray-100" />

        @foreach($models as $sale)
            <x-fab::lists.table.row :odd="$loop->odd">
                @if($this->shouldShowColumn('reference'))
                    <x-fab::lists.table.column>
                        <a href="{{ route('lego.storefront.sales.edit', $sale) }}">{{ $sale->order->reference }}</a>
                    </x-fab::lists.table.column>
                @endif

                @if($this->shouldShowColumn('customer_name'))
                    <x-fab::lists.table.column primary full>
                        <a href="{{ route('lego.storefront.sales.edit', $sale) }}">{{ $sale->order->customer_name }}</a>
                        <p class="py-1 font-normal text-gray-400 text-xs">{{ $sale->order->customer_phone }}</p>
                    </x-fab::lists.table.column>
                @endif

                @if($this->shouldShowColumn('status'))
                    <x-fab::lists.table.column>
                        <a href="{{ route('lego.storefront.sales.edit', $sale) }}">{{ $sale->order->status }}</a>
                    </x-fab::lists.table.column>
                @endif

                @if($this->shouldShowColumn('item'))
                    <x-fab::lists.table.column>
                        @php
                            $products = $sale->order->orderedProducts->map(function($item) {
                                return $item->product->title;
                            });
                        @endphp
                        <a href="{{ route('lego.storefront.sales.edit', $sale) }}">{{ $products->implode(',') }}</a>
                    </x-fab::lists.table.column>
                @endif

                @if($this->shouldShowColumn('amount'))
                    <x-fab::lists.table.column>
                        <a href="{{ route('lego.storefront.sales.edit', $sale) }}">{{ $sale->order->payments?->first()->amount / 100 }}</a>
                    </x-fab::lists.table.column>
                @endif

                @if($this->shouldShowColumn('updated_at'))
                    <x-fab::lists.table.column align="right">
                        {{ $sale->order->updated_at->toFormattedDateString() }}
                    </x-fab::lists.table.column>
                @endisset

                <x-fab::lists.table.column align="right" slim>
                    <a href="{{ route('lego.storefront.sales.edit', $sale) }}">Edit</a>
                </x-fab::lists.table.column>
            </x-fab::lists.table.row>
        @endforeach
    </x-fab::lists.table>

    @include('lego::models._includes.indexes.pagination')
</x-fab::layouts.page>
