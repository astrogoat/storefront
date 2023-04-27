<x-fab::overlays.simple title="Options meta">
    <x-fab::forms.select
        class="mt-6 mb-6"
        label="Type"
        wire:model="meta.content_type"
    >
        <option value="text">Text</option>
        <option value="color">Color</option>
    </x-fab::forms.select>

    <x-fab::lists.table>
        @foreach($this->option['values'] as $value)
            <x-fab::lists.table.row :odd="$loop->odd">
                <x-fab::lists.table.column>{{ $value }}</x-fab::lists.table.column>
                <x-fab::lists.table.column>
                    @switch($meta['content_type'])
                        @case('text')
                        @default
                            <x-fab::forms.input
                                wire:model.debounce="meta.values.{{ $value }}"
                            />
                            @break
                        @case('color')
                            <x-fab::forms.input
                                wire:model.debounce="meta.values.{{ $value }}"
                                type="color"
                            />
                            @break
                    @endswitch
                </x-fab::lists.table.column>
            </x-fab::lists.table.row>
        @endforeach
    </x-fab::lists.table>

    <x-slot name="footer">
        <x-fab::elements.button primary wire:click="update">Update</x-fab::elements.button>
        <x-fab::elements.button wire:click="closeModal" class="mr-4">Close</x-fab::elements.button>
    </x-slot>
</x-fab::overlays.simple>
