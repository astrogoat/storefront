<x-fab::layouts.page
    :title="'#'.$model->reference ?: 'Untitled'"
    :breadcrumbs="[
            ['title' => 'Home', 'url' => route('lego.dashboard')],
            ['title' => 'Orders', 'url' => route('lego.storefront.orders.index')],
            ['title' => $model->reference ?: 'Untitled'],
        ]"
    x-data=""
    x-on:keydown.meta.s.window.prevent="$wire.call('save')" {{-- For Mac --}}
    x-on:keydown.ctrl.s.window.prevent="$wire.call('save')" {{-- For PC  --}}
>
    <div class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 lg:pb-24">
            <div class="flex flex-row sm:flex-col justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">Order summary</h1>
                    <p class="mt-2 text-sm text-gray-500">Check the status of this order, manage status, and download invoices.</p>
                </div>
                <div>
                    @if($this->hasCompletedPayment())
                        <a href="{{ route('orders.invoice', $model) }}" target="_blank" class="mt-6 flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:w-auto">
                            View Invoice
                            <span class="sr-only">for order WU88191111</span>
                        </a>
                    @endif
                </div>
            </div>

            <div class="mt-8">

                <div class="space-y-20">
                    <div>
                        <div class="rounded-lg bg-gray-50 px-4 py-6 sm:flex sm:items-center sm:justify-between sm:space-x-6 sm:px-6 lg:space-x-8">
                            <dl class="flex-auto text-sm text-gray-600 sm:grid grid-cols-4 gap-4 sm:space-y-0 lg:w-1/2 lg:flex-none">
                                <div class="flex justify-between sm:block">
                                    <dt class="font-medium text-gray-900">Date placed</dt>
                                    <dd class="sm:mt-1">
                                        <time datetime="2021-01-22">{{ $model->created_at->toFormattedDateString() }}</time>
                                    </dd>
                                </div>
                                <div class="flex justify-between sm:block">
                                    <dt class="font-medium text-gray-900">Order number</dt>
                                    <dd class="sm:mt-1">#{{ $model->reference }}</dd>
                                </div>
                                <div class="flex justify-between font-medium text-gray-900 sm:block sm:pt-0">
                                    <dt>Total amount</dt>
                                    @php
                                        $total = 0;
                                        $currency = $model->payments?->first()->currency ?? '';
                                        foreach ($model->orderedProducts as $orderRecord) {
                                            $price = $orderRecord->product?->price ?: 0;
                                            $total = $total + $price;
                                        }
                                    @endphp
                                    <dd class="sm:mt-1">{{ $currency }}<b>{{ $total }}</b></dd>
                                </div>
                                <div class="flex justify-between sm:block">
                                    <dt class="font-medium text-gray-900">Order status</dt>
                                    <dd class="sm:mt-1">
                                        <x-fab::forms.select
                                            wire:model="model.status"
                                        >
                                            <option value="order placed">Order placed</option>
                                            <option value="processing">Processing</option>
                                            <option value="shipped">Shipped</option>
                                            <option value="delivered">Delivered</option>
                                            <option value="cancelled">Cancelled</option>
                                        </x-fab::forms.select>
                                    </dd>
                                </div>
                                <div class="flex justify-between sm:block">
                                    <dt class="font-medium text-gray-900">Customer name</dt>
                                    <dd class="sm:mt-1">{{ $model->customer_name }}</dd>
                                </div>
                                <div class="flex justify-between sm:block">
                                    <dt class="font-medium text-gray-900">Customer email</dt>
                                    <dd class="sm:mt-1">{{ $model->customer_email }}</dd>
                                </div>
                                <div class="flex justify-between sm:block">
                                    <dt class="font-medium text-gray-900">Customer phone</dt>
                                    <dd class="sm:mt-1">{{ $model->customer_phone }}</dd>
                                </div>
                                <div class="flex justify-between sm:block">
                                    <dt class="font-medium text-gray-900">Customer Address</dt>
                                    <dd class="sm:mt-1">{{ $model->customer_street }}, {{ $model->customer_city }}, {{ $model->customer_state }}, {{ $model->customer_country }}</dd>
                                </div>
                            </dl>
                        </div>

                        <h1 class="text-2xl mt-6 font-bold tracking-tight text-gray-900 sm:text-3xl">Products</h1>
                        <table class="mt-4 w-full text-gray-500 sm:mt-6">
                            <caption class="sr-only">
                                Products
                            </caption>
                            <thead class="text-left text-sm text-gray-500">
                            <tr class="divide-b divide-gray-200 border-b border-gray-200">
                                <th scope="col" class="py-3 pr-8 font-normal sm:w-2/5 lg:w-1/3">Product</th>
                                <th scope="col" class="w-1/5 py-3 pr-8 font-normal sm:table-cell">Price</th>
                                <th scope="col" class="w-1/5 py-3 pr-8 font-normal sm:table-cell">Quantity</th>
{{--                                <th scope="col" class="py-3 pr-8 font-normal sm:table-cell">Status</th>--}}
                                <th scope="col" class="w-0 py-3 text-right font-normal">Info</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 border-b border-gray-200 text-sm sm:border-t">
                            @php
                                $orderRecords = $this->model->orderedProducts ?? collect([]);
                            @endphp
                            @foreach ($orderRecords as $orderRecord)
                                <tr>
                                    <td class="py-6 pr-8">
                                        <div class="flex items-center">
                                            <img src="{{ $orderRecord->product?->getFirstMedia('Carousel')->getUrl() }}" alt="Detail of mechanical pencil tip with machined black steel shaft and chrome lead tip." class="mr-4 h-16 w-16 rounded object-cover object-center">
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $orderRecord->product?->title ?: 'Product no longer exists' }}</div>
                                                <div class="mt-1 sm:hidden">${{ $orderRecord->product?->price ?: '0' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-6 pr-8 sm:table-cell">${{ $orderRecord->product?->price ?: '0' }}</td>
                                    <td class="py-6 pr-8 sm:table-cell">{{ $orderRecord->quantity ?: '0' }}</td>
{{--                                    <td class="py-6 pr-8 sm:table-cell"><span class="capitalize">{{ $orderRecord->order->status }}</span> {{ $orderRecord->updated_at->toFormattedDateString() }}</td>--}}
                                    <td class="whitespace-nowrap py-6 text-right font-medium">
                                        @unless(!$orderRecord->product)
                                            <a href="{{ route('lego.storefront.products.edit', $orderRecord->product) }}" class="text-indigo-600">View Product<span class="hidden lg:inline">Product</span><span class="sr-only">, Machined Pen and Pencil Set</span></a>
                                        @endunless
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <h1 class="text-2xl mt-6 font-bold tracking-tight text-gray-900 sm:text-3xl">Payment</h1>
                        <table class="mt-4 w-full text-gray-500 sm:mt-6">
                            <caption class="sr-only">
                                Payments
                            </caption>
                            <thead class="text-left text-sm text-gray-500">
                            <tr class="divide-b divide-gray-200 border-b border-gray-200">
                                <th scope="col" class="w-1/5 py-3 pr-8 font-normal sm:table-cell">Reference</th>
                                <th scope="col" class="py-3 pr-8 font-normal sm:table-cell">Status</th>
                                <th scope="col" class="w-1/5 py-3 pr-8 font-normal sm:table-cell">Amount</th>
                                <th scope="col" class="w-1/5 py-3 pr-8 font-normal sm:table-cell">Method</th>
                                <th scope="col" class="w-1/5 py-3 pr-8 font-normal sm:table-cell">Bank</th>
                                <th scope="col" class="w-0 py-3 text-right font-normal">Created</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 border-b border-gray-200 text-sm sm:border-t">
                            @php
                                $paymentRecords = $this->model->payments ?? collect([]);
                            @endphp
                            @foreach ($paymentRecords as $paymentRecord)
                                <tr>
                                    <td class="py-6 pr-8 sm:table-cell">{{ $paymentRecord->reference }}</td>
                                    <td class="py-6 pr-8 sm:table-cell"><span class="capitalize">{{ $paymentRecord->status }}</span></td>
                                    <td class="py-6 pr-8 sm:table-cell">{{ $paymentRecord->currency }}<b>{{ $paymentRecord->amount / 100 }}</b></td>
                                    <td class="py-6 pr-8 sm:table-cell">{{ $paymentRecord->method }}</td>
                                    <td class="py-6 pr-8 sm:table-cell">{{ $paymentRecord->bank }}</td>
                                    <td class="py-6 pr-8 sm:table-cell">{{ $paymentRecord->created_at->toFormattedDateString() }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- More orders... -->
                </div>
            </div>
        </div>
    </div>
</x-fab::layouts.page>

@push('styles')
    <link href="{{ asset('vendor/storefront/css/storefront.css') }}" rel="stylesheet">
@endpush
