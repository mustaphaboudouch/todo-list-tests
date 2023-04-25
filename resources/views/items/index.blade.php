<x-app-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Items') }}
        </h2>
        <x-link :href="route('items.create')">
            {{ __('Add new item') }}
        </x-link>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 flex flex-col gap-4">
                    @foreach ($items as $item)
                        <a href="{{ route('items.show', $item) }}"
                            class="border flex flex-col gap-1 p-4 rounded-md hover:bg-gray-50">
                            <h3 class="text-xl font-bold">{{ $item->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $item->created_at }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
