@php($brickKey = isset($repeaterBrickName) ? "{$repeaterBrickName}.{$index}.{$brickName}" : $brickName)
@php($collectionInputId = md5($this->_id . '.' . $brickKey))

<div
    x-on:{{ $collectionInputId }}.window="$wire.set('{{ $brickKey }}', $event.detail)"
>
    <div class="sh-block sh-text-sm sh-font-medium sh-text-gray-700 sh-mb-0.5">{{ $brick->name }}</div>

    @if($this->get($brickKey)->getCollection())
        <span class="sh-inline-flex sh-items-center sh-py-0.5 sh-pl-2.5 sh-pr-1 sh-rounded-md sh-text-sm sh-font-medium sh-bg-gray-100 sh-text-gray-700 sh-mt-2">
            {{ $this->get($brickKey)->getCollection()->title }}
            <button
                type="button"
                class="sh-flex-shrink-0 sh-rounded-md sh-ml-1 sh-h-4 sh-w-4 sh-inline-flex sh-items-center sh-justify-center sh-text-gray-400 hover:sh-bg-gray-200 hover:sh-text-gray-500 focus:sh-outline-none focus:sh-bg-gray-500 focus:sh-text-white"
                x-on:click="$wire.set('{{ $brickKey }}', null)"
            >
                <span class="sh-sr-only">Remove collection</span>
                <x-fab::elements.icon icon="x" type="solid" class="sh-h-3 sh-w-3" />
          </button>
        </span>
    @else
        <x-fab::elements.button
            size="sm"
            x-on:click="$modal.open('astrogoat.shopify.browse-collections', {{ json_encode([
                'collectionInputId' => $collectionInputId
            ]) }})"
        >
            Select Collection
        </x-fab::elements.button>
    @endif

    @if($brick->help)
        <p class="fab-help-text sh-mt-1 sh-text-sm sh-text-gray-500">{{ $brick->help }}</p>
    @endif
</div>

@push('styles')
    <link href="{{ asset('vendor/shopify/css/shopify.css') }}" rel="stylesheet">
@endpush
