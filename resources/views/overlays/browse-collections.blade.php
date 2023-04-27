<x-fab::overlays.simple
    class=""
>
    <div class="sh-p-4"
    >
        <x-fab::forms.input
            placeholder="Search..."
            x-on:fab-input.debounce.500="$wire.set('query', $event.detail)"
        >
            <x-slot name="icon">
                <x-fab::elements.icon icon="search" class="sh-h-5 sh-w-5" />
            </x-slot>
        </x-fab::forms.input>
    </div>

    <nav class="sh-h-full sh-overflow-y-auto">
        <ul role="list" class="sh-relative sh-z-0 sh-divide-y sh-divide-gray-200">
            @foreach($collections as $collection)
                <li wire:click="select('{{ $collection->id }}')" class="sh-bg-white">
                    <div class="sh-relative sh-px-6 sh-py-5 sh-flex sh-items-center sh-space-x-3 hover:sh-bg-gray-50 focus-within:sh-ring-2 focus-within:sh-ring-inset focus-within:sh-ring-indigo-500">
                        <div class="sh-flex-shrink-0">
                            <x-fab::elements.icon icon="location-marker" type="outline" class="sh-h-8 sh-w-8" />
                        </div>
                        <div class="sh-flex-1 sh-min-w-0">
                            <a href="#" class="focus:sh-outline-none">
                                <!-- Extend touch target to entire panel -->
                                <span class="sh-absolute sh-inset-0" aria-hidden="true"></span>
                                <p class="sh-text-sm sh-font-medium sh-text-gray-900">
                                    {{ $collection->title }}
                                </p>
                                <p class="sh-text-sm sh-text-gray-500 sh-truncate">
                                    {{ $collection->description }}
                                </p>
                            </a>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </nav>

</x-fab::overlays.simple>

