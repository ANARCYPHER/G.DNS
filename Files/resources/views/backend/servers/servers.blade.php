<x-jet-form-section submit="update">
    <x-slot name="title">
        {{ __('Servers') }}
    </x-slot>

    <x-slot name="description">
        {{ __('You can manage the Servers of your Global DNS here.') }}
    </x-slot>
    
    <x-slot name="form">
        @if($addServer || $updateServer)
            <div class="col-span-6 sm:col-span-4">
                <x-jet-secondary-button class="mr-2" wire:click="clearAddUpdate">
                    <i class="fas fa-caret-left"></i> <span class="ml-2">{{ __('Back') }}</span>
                </x-jet-secondary-button>
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" type="text" class="mt-1 block w-full" placeholder="Server Name" wire:model.defer="server.name"/>
                <x-jet-input-error for="server.name" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="url" value="{{ __('URL or DNS Server IP') }}" />
                <x-jet-input id="url" type="text" class="mt-1 block w-full" placeholder="Server URL or IP address of DNS Server" wire:model.defer="server.url"/>
                <x-jet-input-error for="server.url" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="lat" value="{{ __('Latitude') }}" />
                <x-jet-input id="lat" type="text" class="mt-1 block w-full" placeholder="Server Latitude" wire:model.defer="server.lat"/>
                <x-jet-input-error for="server.lat" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="long" value="{{ __('Longitude') }}" />
                <x-jet-input id="long" type="text" class="mt-1 block w-full" placeholder="Server Longitude" wire:model.defer="server.long"/>
                <x-jet-input-error for="server.long" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="country" value="{{ __('Country') }}" />
                <select id="country" class="form-input rounded-md shadow-sm mt-1 block w-full cursor-pointer" wire:model.defer="server.country">
                    <option value="" disabled>{{ __('Select Country') }}</option>
                    @foreach ($countries as $key => $country)
                        <option value="{{ $key }}">{{ $country }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="server.country" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
            <label for="is_active" class="flex cursor-pointer">
                <div class="text-sm">{{ __('Enable') }}</div>
                <div class="ml-3 relative">
                    <input type="checkbox" id="is_active" class="sr-only" wire:model.defer="server.is_active">
                    <div class="dot-bg block bg-gray-600 w-8 h-5 rounded-full"></div>
                    <div class="dot absolute left-1 top-1 bg-white w-3 h-3 rounded-full transition"></div>
                </div>
            </label>
        </div>
        @else
            <div class="col-span-6">
                <input id="import-file" class="hidden" type="file" wire:model="import">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 mb-5">
                    <button id="export" type="button" class="inline-flex items-center justify-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:outline-none focus:border-gray-700 focus:shadow-outline-green active:bg-gray-600 transition ease-in-out duration-150">
                        {{ __('Export') }}
                    </button>
                    <button id="import" type="button" class="inline-flex items-center justify-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:outline-none focus:border-gray-700 focus:shadow-outline-green active:bg-gray-600 transition ease-in-out duration-150">
                        {{ __('Import') }}
                    </button>
                    <button type="button" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-green active:bg-red-600 transition ease-in-out duration-150" onclick="confirm('Are you sure? You will not be able to recover servers once deleted.') || event.stopImmediatePropagation()" wire:click="deleteAll">
                        {{ __('Delete All') }}
                    </button>
                </div>
                @foreach($servers as $server)
                <div class="{{ ($server->is_active) ? 'bg-green-50' : 'bg-red-50' }} text-gray-800 rounded-md px-5 py-4 mt-3 flex justify-between items-center">
                    <div  wire:click="showUpdate({{ $server }})" class="flex space-x-5 cursor-pointer">
                        <img width="32px" src="{{ asset('images/flags/' . strtolower($server->country)) }}.svg">
                        <div>
                            {{ $server->name }}
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <div class="mr-5">
                            @if($server->is_active)
                            <div class="bg-green-200 text-green-800 px-3 py-1 text-xs rounded-full cursor-pointer" wire:click="toggle({{ $server->id }})">Active</div>
                            @else
                            <div class="bg-red-200 text-red-800 px-3 py-1 text-xs rounded-full cursor-pointer" wire:click="toggle({{ $server->id }})">Inactive</div>
                            @endif
                        </div>
                        <div class="cursor-pointer" wire:click="showUpdate({{ $server }})"><i class="fas fa-edit"></i></div>
                        <div class="cursor-pointer" wire:click="delete({{ $server }})"><i class="fas fa-trash-alt"></i></div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>
        @if($addServer || $updateServer)
            @if($addServer)
                <button type="button" class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700" wire:click="add">
                    {{ __('Add') }}
                </button>
            @else
                <button type="button" class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700" wire:click="update">
                    {{ __('Update') }}
                </button>
            @endif
        @else
            <button type="button" class="inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green active:bg-green-600 transition ease-in-out duration-150" wire:click="$toggle('addServer')">
                {{ __('Add Server') }}
            </button>
        @endif
    </x-slot>
</x-jet-form-section>

@section('addonJs')
<script>
    const servers = JSON.parse(`{!! json_encode($servers) !!}`)
    document.getElementById('export').addEventListener('click', e => {
        let csv = 'name,url,long,lat,country'
        servers.forEach(server => {
            csv += `\n"${server.name}",${server.url},${server.long},${server.lat},${server.country}`
        })
        csv = 'data:text/csv;charset=utf-8,' + csv
        let encodedUri = encodeURI(csv);
        let link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', `servers.csv`);
        document.body.appendChild(link);
        link.click();
    })
    document.getElementById('import').addEventListener('click', e => {
        document.getElementById('import-file').click()
    })
</script>
@endsection