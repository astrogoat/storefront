<x-fab::overlays.simple>
    <div class="sm:sh-flex sm:sh-items-center">
        <div class="sm:sh-flex-auto">
            <h1 class="sh-text-xl sh-font-semibold sh-text-gray-900">Webhooks</h1>
            <p class="sh-mt-2 sh-text-sm sh-text-gray-700">A list of all registered webhooks for this Shopify store.</p>
        </div>
    </div>
    <div class="sh-mt-8 sh-flex sh-flex-col">
        <div class="sh--my-2 sh--mx-4 sh-overflow-x-auto sm:sh--mx-6 lg:sh--mx-8">
            <div class="sh-inline-block sh-min-w-full sh-py-2 sh-align-middle md:sh-px-6 lg:sh-px-8">
                <div class="sh-overflow-hidden sh-shadow sh-ring-1 sh-ring-black sh-ring-opacity-5 md:sh-rounded-lg">
                    <table class="sh-min-w-full sh-divide-y sh-divide-gray-300">
                        <thead class="sh-bg-gray-50">
                        <tr>
                            <th scope="col" class="sh-py-3.5 sh-pl-4 sh-pr-3 sh-text-left sh-text-sm sh-font-semibold sh-text-gray-900 sm:sh-pl-6">Event</th>
                            <th scope="col" class="sh-px-3 sh-py-3.5 sh-text-left sh-text-sm sh-font-semibold sh-text-gray-900">Callback URL</th>
                            <th scope="col" class="sh-px-3 sh-py-3.5 sh-text-left sh-text-sm sh-font-semibold sh-text-gray-900">Format</th>
                            <th scope="col" class="sh-px-3 sh-py-3.5 sh-text-left sh-text-sm sh-font-semibold sh-text-gray-900">Updated on</th>
                            <th scope="col" class="sh-relative sh-py-3.5 sh-pl-3 sh-pr-4 sm:sh-pr-6">
                                <span class="sh-sr-only">Delete</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="sh-divide-y sh-divide-gray-200 sh-bg-white">
                            @foreach($this->webhooks as $webhook)
                                <tr>
                                    <td class="sh-whitespace-nowrap sh-py-4 sh-pl-4 sh-pr-3 sh-text-sm sh-font-medium sh-text-gray-900 sm:sh-pl-6">{{ $webhook['topic'] }}</td>
                                    <td class="sh-whitespace-nowrap sh-px-3 sh-py-4 sh-text-sm sh-text-gray-500">{{ $webhook['address'] }}</td>
                                    <td class="sh-whitespace-nowrap sh-px-3 sh-py-4 sh-text-sm sh-text-gray-500">{{ $webhook['format'] }}</td>
                                    <td class="sh-whitespace-nowrap sh-px-3 sh-py-4 sh-text-sm sh-text-gray-500">{{ $this->displayDate($webhook['updated_at']) }}</td>
                                    <td class="sh-relative sh-whitespace-nowrap sh-py-4 sh-pl-3 sh-pr-4 sh-text-right sh-text-sm sh-font-medium sm:sh-pr-6">
                                        <a href="#" wire:click="deleteWebhook('{{ $webhook['id'] }}')" class="sh-text-indigo-600 hover:sh-text-indigo-900">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="footer">
        <x-fab::elements.button wire:click="closeModal">Close</x-fab::elements.button>
    </x-slot>
</x-fab::overlays.simple>
