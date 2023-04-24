<x-jet-form-section submit="update">
    <x-slot name="title">
        {{ __('Configuration') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Global DNS specific settings which are applied on the App functionality.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6">
            <div class="grid grid-cols-3">
                <div class="flex-1">
                    <x-jet-label for="success_image" value="{{ __('Success Image') }}" />
                    @if ($success_image)
                        <img class="max-w-status rounded my-2 p-2 striped-img-preview" src="{{ $success_image->temporaryUrl() }}">
                    @elseif ($state['status_images']['success'])
                        <img class="max-w-status rounded my-2 p-2 striped-img-preview" src="{{ $state['status_images']['success'] }}">
                    @else
                        <img class="max-w-status rounded my-2 p-2 striped-img-preview" src="{{ asset('images/status/success.png') }}">
                    @endif
                    <input class="mt-2 text-sm" type="file" wire:model="success_image">
                    <x-jet-input-error for="success_image" class="mt-2" />
                </div>
                <div class="flex-1">
                    <x-jet-label for="error_image" value="{{ __('Error Image') }}" />
                    @if ($error_image)
                        <img class="max-w-status rounded my-2 p-2 striped-img-preview" src="{{ $error_image->temporaryUrl() }}">
                    @elseif ($state['status_images']['error'])
                        <img class="max-w-status rounded my-2 p-2 striped-img-preview" src="{{ $state['status_images']['error'] }}">
                    @else
                        <img class="max-w-status rounded my-2 p-2 striped-img-preview" src="{{ asset('images/status/error.png') }}">
                    @endif
                    <input class="mt-2 text-sm" type="file" wire:model="error_image">
                    <x-jet-input-error for="error_image" class="mt-2" />
                </div>
                <div class="flex-1">
                    <x-jet-label for="pending_image" value="{{ __('Pending Image') }}" />
                    @if ($pending_image)
                        <img class="max-w-status rounded my-2 p-2 striped-img-preview" src="{{ $pending_image->temporaryUrl() }}">
                    @elseif ($state['status_images']['pending'])
                        <img class="max-w-status rounded my-2 p-2 striped-img-preview" src="{{ $state['status_images']['pending'] }}">
                    @else
                        <img class="max-w-status rounded my-2 p-2 striped-img-preview" src="{{ asset('images/status/pending.png') }}">
                    @endif
                    <input class="mt-2 text-sm" type="file" wire:model="pending_image">
                    <x-jet-input-error for="pending_image" class="mt-2" />
                </div>
            </div>
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="font_family" value="{{ __('Font Family') }}" />
            <x-jet-input id="font_family" type="text" class="mt-1 block w-full" min="10" wire:model.defer="state.font_family" />
            <x-jet-input-error for="state.font_family" class="mt-2" />
            <small>{{ __('Use') }} <a href="https://fonts.google.com/" class="underline" target="_blank" rel="noopener noreferrer">{{ __('Google Fonts') }}</a> {{ __('with exact name') }}</small>
        </div>
        <div class="col-span-6">
            <x-jet-label for="quill-content-above" value="{{ __('Text above Map') }}" />
            <div class="mt-1"><div class="quill-content" id="quill-content-above">{!! $state['text']['above_map'] !!}</div></div>
            <textarea id="content-above" class="hidden" wire:model.defer="state.text.above_map"></textarea>
        </div>
        <div class="col-span-6">
            <x-jet-label for="quill-content-below" value="{{ __('Text below Map') }}" />
            <div class="mt-1"><div class="quill-content" id="quill-content-below">{!! $state['text']['below_map'] !!}</div></div>
            <textarea id="content-below" class="hidden" wire:model.defer="state.text.below_map"></textarea>
        </div>
        <div class="col-span-6">
            <x-jet-label for="quill-content-footer" value="{{ __('Text below Map') }}" />
            <div class="mt-1"><div class="quill-content" id="quill-content-footer">{!! $state['text']['footer'] !!}</div></div>
            <textarea id="content-footer" class="hidden" wire:model.defer="state.text.footer"></textarea>
        </div>
        <div class="col-span-6">
            <x-jet-label for="quill-content-footer" value="{{ __('Find Button') }}" />
        </div>
        <div class="col-span-6">
            <div class="flex space-x-5">
                <div class="flex-1">
                    <x-jet-label for="find_btn_text" value="{{ __('Text') }}" />
                    <x-jet-input id="find_btn_text" type="text" class="mt-1 block w-full" min="10" wire:model.defer="state.find_btn.text" />
                    <x-jet-input-error for="state.find_btn.text" class="mt-2" />
                </div>
                <div x-data="{ color: '{{ $state['find_btn']['color'] }}' }" class="flex-1">
                    <x-jet-label value="{{ __('Color') }}" />
                    <div class="relative">
                        <label for="find_btn_color">
                            <div x-bind:style="`background-color: ${color}`" class="mt-1 rounded-md cursor-pointer h-10 w-20"></div>
                        </label>
                        <input x-model="color" id="find_btn_color" type="color" class="absolute top-5 left-0 invisible" wire:model.defer="state.find_btn.color" />
                    </div>
                    <x-jet-input-error for="state.find_btn.color" class="mt-2" />
                </div>
                <div x-data="{ color: '{{ $state['find_btn']['text_color'] }}' }" class="flex-1">
                    <x-jet-label for="find_btn_text_color" value="{{ __('Text Color') }}" />
                    <div class="relative">
                        <label for="find_btn_text_color">
                            <div x-bind:style="`background-color: ${color}`" class="mt-1 rounded-md cursor-pointer h-10 w-20"></div>
                        </label>
                        <input x-model="color" id="find_btn_text_color" type="color" class="absolute top-5 left-0 invisible" wire:model.defer="state.find_btn.text_color" />
                    </div>
                    <x-jet-input-error for="state.find_btn.text_color" class="mt-2" />
                </div>
            </div>
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="default_dns" value="{{ __('Default DNS Type') }}" />
            <div class="relative">
                <select id="default_dns" class="form-input rounded-md shadow-sm mt-1 block w-full cursor-pointer" wire:model.defer="state.default_dns">
                    <option value="A" title="Host address (dotted quad)" selected="">A</option>
                    <option value="MX" title="Mail exchanger (preference value, domain name)">MX</option>
                    <option value="NS" title="Authoritative nameserver (domain name)">NS</option>
                    <option value="CNAME" title="Canonical name for an alias (domain name)">CNAME</option>
                    <option value="TXT" title="Descriptive text (one or more strings)">TXT</option>
                    <option value="PTR" title="Domain name pointer (Provide IP Address)">PTR</option>
                    <option value="CAA" title="Certification Authority Authorization">CAA</option>
                    <option value="SOA" title="Start of Authority">SOA</option>
                    <option value="SRV" title="Service record">SRV</option>
                    <option value="AAAA" title="IP v6 address (address spec with colons)">AAAA</option>
                </select>
            </div>
            <x-jet-input-error for="state.default_dns" class="mt-2" />
        </div>
        <div class="col-span-6">
            <x-jet-label for="quill-content-footer" value="{{ __('WHOIS Lookup Button') }}" />
        </div>
        <div class="col-span-6">
            <div class="flex space-x-5">
                <div class="flex-1">
                    <x-jet-label for="whois_btn_text" value="{{ __('Text') }}" />
                    <x-jet-input id="whois_btn_text" type="text" class="mt-1 block w-full" min="10" wire:model.defer="state.whois_btn.text" />
                    <x-jet-input-error for="state.whois_btn.text" class="mt-2" />
                </div>
                <div x-data="{ color: '{{ $state['whois_btn']['color'] }}' }" class="flex-1">
                    <x-jet-label value="{{ __('Color') }}" />
                    <div class="relative">
                        <label for="whois_btn_color">
                            <div x-bind:style="`background-color: ${color}`" class="mt-1 rounded-md cursor-pointer h-10 w-20"></div>
                        </label>
                        <input x-model="color" id="whois_btn_color" type="color" class="absolute top-5 left-0 invisible" wire:model.defer="state.whois_btn.color" />
                    </div>
                    <x-jet-input-error for="state.whois_btn.color" class="mt-2" />
                </div>
                <div x-data="{ color: '{{ $state['whois_btn']['text_color'] }}' }" class="flex-1">
                    <x-jet-label for="whois_btn_text_color" value="{{ __('Text Color') }}" />
                    <div class="relative">
                        <label for="whois_btn_text_color">
                            <div x-bind:style="`background-color: ${color}`" class="mt-1 rounded-md cursor-pointer h-10 w-20"></div>
                        </label>
                        <input x-model="color" id="whois_btn_text_color" type="color" class="absolute top-5 left-0 invisible" wire:model.defer="state.whois_btn.text_color" />
                    </div>
                    <x-jet-input-error for="state.whois_btn.text_color" class="mt-2" />
                </div>
            </div>
        </div>
        <div class="col-span-6 sm:col-span-4">
            <label for="enable_logs" class="flex cursor-pointer">
                <div class="text-sm">{{ __('Enable Logs') }}</div>
                <div class="ml-3 relative">
                    <input type="checkbox" id="enable_logs" class="sr-only" wire:model.defer="state.enable_logs">
                    <div class="dot-bg block bg-gray-600 w-8 h-5 rounded-full"></div>
                    <div class="dot absolute left-1 top-1 bg-white w-3 h-3 rounded-full transition"></div>
                </div>
            </label>
        </div>
        <div class="col-span-6 sm:col-span-4">
            <label for="show_dark_mode" class="flex cursor-pointer">
                <div class="text-sm">{{ __('Show Dark Mode Toggle') }}</div>
                <div class="ml-3 relative">
                    <input type="checkbox" id="show_dark_mode" class="sr-only" wire:model.defer="state.show_dark_mode">
                    <div class="dot-bg block bg-gray-600 w-8 h-5 rounded-full"></div>
                    <div class="dot absolute left-1 top-1 bg-white w-3 h-3 rounded-full transition"></div>
                </div>
            </label>
        </div>
        <div class="col-span-6 sm:col-span-4">
            <label for="enable_ad_block_detector" class="flex cursor-pointer">
                <div class="text-sm">{{ __('Enable Ad Block Detector') }}</div>
                <div class="ml-3 relative">
                    <input type="checkbox" id="enable_ad_block_detector" class="sr-only" wire:model.defer="state.enable_ad_block_detector">
                    <div class="dot-bg block bg-gray-600 w-8 h-5 rounded-full"></div>
                    <div class="dot absolute left-1 top-1 bg-white w-3 h-3 rounded-full transition"></div>
                </div>
            </label>
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="timeout" value="{{ __('Timeout (Seconds)') }}" />
            <x-jet-input id="timeout" type="text" class="mt-1 block w-full" min="3" wire:model.defer="state.timeout" />
            <x-jet-input-error for="state.timeout" class="mt-2" />
            <small>{{ __('Timeout is X seconds after which DNS query request are cancelled') }}</small>
        </div>
        <div x-data="{ enable_recaptcha: {{ $state['recaptcha']['enabled'] ? 'true' : 'false' }} }" class="col-span-6 sm:col-span-4 hidden">
            <label for="enable_recaptcha" class="flex cursor-pointer">
                <div class="text-sm">{{ __('Enable reCaptcha') }}</div>
                <div class="ml-3 relative">
                    <input x-model="enable_recaptcha" type="checkbox" id="enable_recaptcha" class="sr-only" wire:model.defer="state.recaptcha.enable">
                    <div class="dot-bg block bg-gray-600 w-8 h-5 rounded-full"></div>
                    <div class="dot absolute left-1 top-1 bg-white w-3 h-3 rounded-full transition"></div>
                </div>
            </label>
            <div x-show="enable_recaptcha" class="mt-6">
                <div>
                    <x-jet-label for="recaptcha_site_key" value="{{ __('Site Key') }}" />
                    <x-jet-input id="recaptcha_site_key" type="text" class="mt-1 block w-full" wire:model.defer="state.recaptcha.site_key" />
                    <x-jet-input-error for="state.recaptcha.site_key" class="mt-1 mb-2" />
                </div>
                <div class="mt-2">
                    <x-jet-label for="recaptcha_secret_key" value="{{ __('Secret Key') }}" />
                    <x-jet-input id="recaptcha_secret_key" type="text" class="mt-1 block w-full" wire:model.defer="state.recaptcha.secret_key" />
                    <x-jet-input-error for="state.recaptcha.site_key" class="mt-1 mb-2" />
                </div>
            </div>
        </div>
        <script>
        function loadQuill() {
            var toolbarOptions = [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'align': [] }],
                ['link', 'code-block'],
                [{ 'color': [] }, { 'background': [] }],
                ['clean']
            ];
            if(document.querySelector('.ql-toolbar') === null) {
                const options = {
                    modules: {
                        toolbar: toolbarOptions
                    },
                    theme: 'snow',
                };
                var quill_above = new Quill('#quill-content-above', options);
                var quill_below = new Quill('#quill-content-below', options);
                var quill_footer = new Quill('#quill-content-footer', options);
            }
        }
        function loadEventListeners() {
            setInterval(() => {
                document.querySelector('#content-above').value = document.querySelector('#quill-content-above .ql-editor').innerHTML;
                document.querySelector('#content-above').dispatchEvent(new Event('input'));
                document.querySelector('#content-below').value = document.querySelector('#quill-content-below .ql-editor').innerHTML;
                document.querySelector('#content-below').dispatchEvent(new Event('input'));
                document.querySelector('#content-footer').value = document.querySelector('#quill-content-footer .ql-editor').innerHTML;
                document.querySelector('#content-footer').dispatchEvent(new Event('input'));
            }, 500);
        }
        if(document.querySelector('.quill-content')) {
            loadQuill()
            loadEventListeners()
            window.addEventListener('componentUpdated', event => {
                loadQuill()
                loadEventListeners()
            });
        }
        </script>
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