<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(!$stats['logs_enabled'])
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
            <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                <div class="p-10">
                    <strong class="text-2xl">
                        {{ __('Hi') }} {{ explode(' ', Auth::user()->name)[0] }}!
                    </strong>
                    <div class="mt-2 text-gray-500">
                        {{ __('Welcome to Global DNS - PHP Dashboard') }}
                    </div>
                </div>
                <div class="bg-gray-50 text-gray-800 grid grid-cols-1 md:grid-cols-2 p-10 space-x-10">
                    <div>
                        <div class="flex items-center">
                            <div class="text-lg leading-7 font-semibold"><a href="https://support.thehp.in/articles/100016780" target="_blank">{{ __('Articles') }}</a></div>
                        </div>
                        <div>
                            <div class="mt-2 text-sm">
                                {{ __('A bunch of helpful articles related to Global DNS - PHP can be found in the below portal. This will help on various features of Global DNS- PHP.') }}
                            </div>
                            <a href="https://support.thehp.in/articles/100016780" target="_blank">
                                <div class="mt-3 flex items-center text-sm font-semibold text-sky-700">
                                    <div>{{ __('Explore the Articles') }}</div>
                                    <div class="ml-1 text-sky-700">
                                        <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center">
                            <div class="text-lg leading-7 font-semibold"><a href="https://support.thehp.in/submit/#100016780" target="_blank">{{ __('Support') }}</a></div>
                        </div>
                        <div class="">
                            <div class="mt-2 text-sm">
                                {{ __('In case if you\'re not able to find the right solution of your problem in the Articles section, we\'re always here to help you out at our Support Portal. ') }}
                            </div>
                            <a href="https://support.thehp.in/submit/#100016780" target="_blank">
                                <div class="mt-3 flex items-center text-sm font-semibold text-sky-700">
                                    <div>{{ __('Create a Support Ticket') }}</div>
                                    <div class="ml-1 text-sky-500">
                                        <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-4 gap-6 p-10">
                    <div class="flex space-x-5 items-center">
                        <div class="bg-lime-200 text-lime-600 w-16 h-16 rounded-full flex justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-1 space-y-1">
                            <h3 class="text-xl font-bold">{{ $stats['domain'] }}</h3>
                            <h5 class="text-sm">{{ __('Top Queried Domain') }}</h5>
                        </div>
                    </div>
                    <div class="flex space-x-5 items-center">
                        <div class="bg-cyan-200 text-cyan-600 w-16 h-16 rounded-full flex justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13 7H7v6h6V7z" />
                                <path fill-rule="evenodd" d="M7 2a1 1 0 012 0v1h2V2a1 1 0 112 0v1h2a2 2 0 012 2v2h1a1 1 0 110 2h-1v2h1a1 1 0 110 2h-1v2a2 2 0 01-2 2h-2v1a1 1 0 11-2 0v-1H9v1a1 1 0 11-2 0v-1H5a2 2 0 01-2-2v-2H2a1 1 0 110-2h1V9H2a1 1 0 010-2h1V5a2 2 0 012-2h2V2zM5 5h10v10H5V5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-1 space-y-1">
                            <h3 class="text-xl font-bold">{{ $stats['type'] }}</h3>
                            <h5 class="text-sm">{{ __('Most Used DNS Type') }}</h5>
                        </div>
                    </div>
                    <div class="flex space-x-5 items-center">
                        <div class="bg-violet-200 text-violet-600 w-16 h-16 rounded-full flex justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.243 3.03a1 1 0 01.727 1.213L9.53 6h2.94l.56-2.243a1 1 0 111.94.486L14.53 6H17a1 1 0 110 2h-2.97l-1 4H15a1 1 0 110 2h-2.47l-.56 2.242a1 1 0 11-1.94-.485L10.47 14H7.53l-.56 2.242a1 1 0 11-1.94-.485L5.47 14H3a1 1 0 110-2h2.97l1-4H5a1 1 0 110-2h2.47l.56-2.243a1 1 0 011.213-.727zM9.03 8l-1 4h2.938l1-4H9.031z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-1 space-y-1">
                            <h3 class="text-xl font-bold">{{ $stats['logs_count'] }}</h3>
                            <h5 class="text-sm">{{ __('Total DNS Queries') }}</h5>
                        </div>
                    </div>
                    <div class="flex space-x-5 items-center">
                        <div class="bg-rose-200 text-rose-600 w-16 h-16 rounded-full flex justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm14 1a1 1 0 11-2 0 1 1 0 012 0zM2 13a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2zm14 1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-1 space-y-1">
                            <h3 class="text-xl font-bold">{{ $stats['servers_count'] }}</h3>
                            <h5 class="text-sm">{{ __('Total Servers') }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
