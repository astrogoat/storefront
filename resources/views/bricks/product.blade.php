@php($brickKey = isset($repeaterBrickName) ? "{$repeaterBrickName}.{$index}.{$brickName}" : $brickName)
@php($linkInputId = md5($this->_id . '.' . $brickKey))

<div
    x-on:{{ $linkInputId }}.window="$wire.set('{{ $brickKey . '.productId' }}', $event.detail)"
>
    <div class="sh-block sh-text-sm sh-font-medium sh-text-gray-700 sh-mb-0.5">{{ $brick->name }}</div>

    @if($this->get($brickKey)->getProduct())
        <span class="sh-inline-flex sh-items-center sh-py-0.5 sh-pl-2.5 sh-pr-1 sh-rounded-md sh-text-sm sh-font-medium sh-bg-gray-100 sh-text-gray-700 sh-mt-2">
            {{ $this->get($brickKey)->getProduct()->title }}
            <button
                type="button"
                class="sh-flex-shrink-0 sh-rounded-md sh-ml-1 sh-h-4 sh-w-4 sh-inline-flex sh-items-center sh-justify-center sh-text-gray-400 hover:sh-bg-gray-200 hover:sh-text-gray-500 focus:sh-outline-none focus:sh-bg-gray-500 focus:sh-text-white"
                x-on:click="$wire.set('{{ $brickKey . '.productId' }}', null)"
            >
                <span class="sh-sr-only">Remove product</span>
                <x-fab::elements.icon icon="x" type="solid" class="sh-h-3 sh-w-3" />
          </button>
        </span>

        <x-fab::forms.checkbox
            label="Use specified variants"
            id="useSpecifiedVariants_{{ $linkInputId}}"
            wire:model="{{ $brickKey }}.useSpecifiedVariants"
            class="sh-mt-4"
            help="All variants will be available if unchecked."
        />

        @if($this->get($brickKey)->usesSpecifiedVariants())
            <div :wire:key="$brickKey">
                <x-fab::forms.select
                    wire:model="{{ $brickKey }}.variantIds"
                    multiple
                    class="sh-mt-2"
                    help="Hold CMD on Mac or Control on windows to select multiple."
                >
                    @foreach($this->get($brickKey)->getProduct()->variants as $variant)
                        <option value="{{ $variant->id }}">{{ $variant->title }}</option>
                    @endforeach
                </x-fab::forms.select>
            </div>
        @endif
    @else
        <x-fab::elements.button
            size="sm"
            x-on:click="$modal.open('astrogoat.shopify.browse-products', {{ json_encode([
                'linkInputId' => $linkInputId
            ]) }})"
        >
            Select Product
        </x-fab::elements.button>
    @endif

    @if($brick->help)
        <p class="fab-help-text mt-1 text-sm text-gray-500">{{ $brick->help }}</p>
    @endif
</div>

@push('styles')
    <link href="{{ asset('vendor/shopify/css/shopify.css') }}" rel="stylesheet">
@endpush
