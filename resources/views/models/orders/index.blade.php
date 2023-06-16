<x-fab::layouts.page
    title="Orders"
    :breadcrumbs="[
        ['title' => 'Home', 'url' => route('lego.dashboard')],
        ['title' => 'Orders','url' => route('lego.storefront.orders.index')],
    ]"
    x-data="{ showColumnFilters: true }"
>
    <x-slot name="actions">
        <x-fab::elements.button type="link" :url="route('lego.storefront.orders.create')">Create</x-fab::elements.button>
    </x-slot>

    @include('lego::models._includes.indexes.filters')

    <x-fab::lists.table>
        <x-slot name="headers">
            @include('lego::models._includes.indexes.headers')
            <x-fab::lists.table.header :hidden="true">Edit</x-fab::lists.table.header>
        </x-slot>

        @include('lego::models._includes.indexes.header-filters')
        <x-fab::lists.table.header x-show="showColumnFilters" x-cloak class="bg-gray-100" />

        @foreach($models->reject(function($record) { return $record->status === 'delivered'; }) as $order)
            <x-fab::lists.table.row :odd="$loop->odd">
                @if($this->shouldShowColumn('reference'))
                    <x-fab::lists.table.column>
                        <a href="{{ route('lego.storefront.orders.edit', $order) }}">{{ $order->reference }}</a>
                    </x-fab::lists.table.column>
                @endif

                @if($this->shouldShowColumn('customer_name'))
                    <x-fab::lists.table.column primary full>
                        <a href="{{ route('lego.storefront.orders.edit', $order) }}">{{ $order->customer_name }}</a>
                        <p class="py-1 font-normal text-gray-400 text-xs">{{ $order->customer_phone }}</p>
                    </x-fab::lists.table.column>
                @endif

                @if($this->shouldShowColumn('status'))
                    <x-fab::lists.table.column>
                        <a href="{{ route('lego.storefront.orders.edit', $order) }}">{{ $order->status }}</a>
                    </x-fab::lists.table.column>
                @endif

                @if($this->shouldShowColumn('item'))
                    <x-fab::lists.table.column>
                        @php
                            $products = $order->orderedProducts->map(function($item) {
                                return $item->product?->title;
                            });
                        @endphp
                        <a href="{{ route('lego.storefront.orders.edit', $order) }}">{{ $products->implode(',') }}</a>
                    </x-fab::lists.table.column>
                @endif

                @if($this->shouldShowColumn('amount'))
                    <x-fab::lists.table.column>
                        <a href="{{ route('lego.storefront.orders.edit', $order) }}">{{ $order->payments?->first()?->amount / 100 }}</a>
                    </x-fab::lists.table.column>
                @endif

                @if($this->shouldShowColumn('updated_at'))
                    <x-fab::lists.table.column align="right">
                        {{ $order->updated_at->toFormattedDateString() }}
                    </x-fab::lists.table.column>
                @endisset

                <x-fab::lists.table.column align="right" slim>
                    <a href="{{ route('lego.storefront.orders.edit', $order) }}">Edit</a>
                </x-fab::lists.table.column>
            </x-fab::lists.table.row>
        @endforeach
    </x-fab::lists.table>

    @include('lego::models._includes.indexes.pagination')
</x-fab::layouts.page>
