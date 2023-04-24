<x-jet-form-section submit="update">
    <x-slot name="title">
        {{ __('General') }}
    </x-slot>

    <x-slot name="description">
        {{ __('All the general settings shown here are applied on overall website.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('App Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" />
            <x-jet-input-error for="state.name" class="mt-2" />
        </div>
        @if(!env('APP_DEMO', false))
        <div class="col-span-6 sm:col-span-3">
            <x-jet-label for="logo" value="{{ __('Logo') }}" />
            <input class="mt-2 text-sm" type="file" wire:model="logo">
            @if ($logo)
                <img class="max-w-logo rounded my-2 p-2 striped-img-preview" src="{{ $logo->temporaryUrl() }}">
            @elseif ($state['custom_logo'])
                <img class="max-w-logo rounded my-2 p-2 striped-img-preview" src="{{ $state['custom_logo'] }}">
            @else
                <img class="max-w-logo rounded my-2 p-2 striped-img-preview" src="{{ asset('images/logo.png') }}">
            @endif
            <x-jet-input-error for="logo" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-3">
            <x-jet-label for="favicon" value="{{ __('Favicon') }}" />
            <input class="mt-2 text-sm" type="file" wire:model="favicon">
            @if ($favicon)
                <img class="max-w-favicon rounded my-2 p-2 striped-img-preview" src="{{ $favicon->temporaryUrl() }}">
            @elseif ($state['custom_favicon'])
                <img class="max-w-favicon rounded my-2 p-2 striped-img-preview" src="{{ $state['custom_favicon'] }}">
            @else
                <img class="max-w-favicon rounded my-2 p-2 striped-img-preview"
                    src="{{ asset('images/favicon.png') }}">
            @endif
            <x-jet-input-error for="favicon" class="mt-2" />
        </div>
        @endif
        <div class="col-span-6">
            <div class="flex">
                <div x-data="{ color: '{{ $state['colors']['primary'] }}' }" class="flex-1">
                    <x-jet-label value="{{ __('Primary Color') }}" />
                    <div class="relative">
                        <label for="primary_color">
                            <div x-bind:style="`background-color: ${color}`"
                                class="mt-1 rounded-md cursor-pointer h-10 w-20"></div>
                        </label>
                        <input x-model="color" id="primary_color" type="color" class="absolute top-5 left-0 invisible"
                            wire:model.defer="state.colors.primary" />
                    </div>
                    <x-jet-input-error for="primary_color" class="mt-2" />
                </div>
                <div x-data="{ color: '{{ $state['colors']['secondary'] }}' }" class="flex-1 hidden">
                    <x-jet-label for="secondary_color" value="{{ __('Secondary Color') }}" />
                    <div class="relative">
                        <label for="secondary_color">
                            <div x-bind:style="`background-color: ${color}`"
                                class="mt-1 rounded-md cursor-pointer h-10 w-20"></div>
                        </label>
                        <input x-model="color" id="secondary_color" type="color" class="absolute top-5 left-0 invisible"
                            wire:model.defer="state.colors.secondary" />
                    </div>
                    <x-jet-input-error for="secondary_color" class="mt-2" />
                </div>
                <div x-data="{ color: '{{ $state['colors']['tertiary'] }}' }" class="flex-1 hidden">
                    <x-jet-label for="tertiary_color" value="{{ __('Tertiary Color') }}" />
                    <div class="relative">
                        <label for="tertiary_color">
                            <div x-bind:style="`background-color: ${color}`"
                                class="mt-1 rounded-md cursor-pointer h-10 w-20"></div>
                        </label>
                        <input x-model="color" id="tertiary_color" type="color" class="absolute top-5 left-0 invisible"
                            wire:model.defer="state.colors.tertiary" />
                    </div>
                    <x-jet-input-error for="tertiary_color" class="mt-2" />
                </div>
            </div>
        </div>
        <div x-data="{ cookie: {{ $state['cookie']['enable'] ? 'true' : 'false' }} }" class="col-span-6 hidden">
            <label for="cookie_input" class="flex cursor-pointer">
                <div class="text-sm">{{ __('Cookie Policy') }}</div>
                <div class="ml-3 relative">
                    <input x-model="cookie" type="checkbox" id="cookie_input" class="sr-only" wire:model.defer="state.cookie.enable">
                    <div class="dot-bg block bg-gray-600 w-8 h-5 rounded-full"></div>
                    <div class="dot absolute left-1 top-1 bg-white w-3 h-3 rounded-full transition"></div>
                </div>
            </label>
            <textarea x-show="cookie" class="form-input rounded-md shadow-sm mt-4 block w-full resize-y border"
                placeholder="Enter the Text to show for Cookie Policy (HTML allowed)"
                wire:model.defer="state.cookie.text"></textarea>
            <x-jet-input-error for="state.cookie" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
