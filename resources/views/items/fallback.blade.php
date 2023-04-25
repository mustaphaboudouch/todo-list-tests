<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('No Items') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 flex flex-col gap-4">
                    <p class="text-center text-lg text-gray-500">
                        {{ __('You don\'t have access because you are not adult.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
