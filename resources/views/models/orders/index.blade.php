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

        @foreach($models as $order)
            <x-fab::lists.table.row :odd="$loop->odd">
                @if($this->shouldShowColumn('reference'))
                    <x-fab::lists.table.column>
                        <a href="{{ route('lego.storefront.orders.edit', $order) }}">{{ $order->reference }}</a>
                    </x-fab::lists.table.column>
                @endif

                @if($this->shouldShowColumn('customer_name'))
                    <x-fab::lists.table.column primary full>
                        <a href="{{ route('lego.storefront.orders.edit', $order) }}">{{ $order->customer_name }}</a>
                    </x-fab::lists.table.column>
                @endif

                @if($this->shouldShowColumn('customer_phone'))
                    <x-fab::lists.table.column>
                        <a href="{{ route('lego.storefront.orders.edit', $order) }}">{{ $order->customer_phone }}</a>
                    </x-fab::lists.table.column>
                @endif

                @if($this->shouldShowColumn('customer_country'))
                    <x-fab::lists.table.column>
                        <a href="{{ route('lego.storefront.orders.edit', $order) }}">{{ $order->customer_country }}</a>
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
