<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(!config('app.settings.enable_logs'))
            <div class="bg-red-50 border border-red-100 w-full flex justify-between items-center rounded-lg p-4 mb-5">
                <div class="flex justify-start items-center space-x-5">
                    <div class="text-red-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <p class="text-sm text-red-800 font-medium">{{ __('Logs are disabled. Please enable to collect usage logs.') }}</p>
                </div>
            </div>
            @endif
            <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6 space-y-5">
                @if(count($logs) == 0)
                <p class="text-center text-sm text-gray-600">{{ __('No Logs Available') }}</p>
                @else
                {{ $logs->links() }}
                <div class="bg-gray-50 rounded-lg overflow-hidden dark:bg-gray-800/25">
                    <table class="border-collapse table-auto w-full text-sm mt-5">
                        <thead>
                            <tr class="border-b">
                                <th class="dark:border-gray-600 font-medium p-4 pl-8 pt-0 pb-3 text-gray-600 dark:text-gray-200 text-left">#</th>
                                <th class="dark:border-gray-600 font-medium p-4 pt-0 pb-3 text-gray-600 dark:text-gray-200 text-left">Domain</th>
                                <th class="dark:border-gray-600 font-medium p-4 pt-0 pb-3 text-gray-600 dark:text-gray-200 text-left">Type</th>
                                <th class="max-w-log dark:border-gray-600 font-medium p-4 pt-0 pb-3 text-gray-600 dark:text-gray-200 text-left">Result</th>
                                <th class="dark:border-gray-600 font-medium p-4 pr-8 pt-0 pb-3 text-gray-600 dark:text-gray-200 text-left">Server ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log) 
                            <tr class="border-b">
                                <td class="border-gray-100 dark:border-gray-700 p-4 pl-8 text-gray-700 dark:text-gray-400">{{ $log->id }}</td>
                                <td class="border-gray-100 dark:border-gray-700 p-4 text-gray-700 dark:text-gray-400">{{ $log->domain }}</td>
                                <td class="border-gray-100 dark:border-gray-700 p-4 text-gray-700 dark:text-gray-400">{{ $log->type }}</td>
                                <td class="max-w-log border-gray-100 dark:border-gray-700 p-4 text-gray-700 dark:text-gray-400">{{ $log->result }}</td>
                                <td class="border-gray-100 dark:border-gray-700 p-4 pr-8 text-gray-700 dark:text-gray-400"><a href="#">{{ $log->server_id }}</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $logs->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
