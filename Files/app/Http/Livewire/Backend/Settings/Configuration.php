<?php

namespace App\Http\Livewire\Backend\Settings;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class Configuration extends Component {

    use WithFileUploads;

    /**
     * Components State
     */
    public $state = [
        'font_family' => 'Poppins',
        'status_images' => [
            'success' => '',
            'error' => '',
            'pending' => ''
        ],
        'text' => [
            'above_map' => '',
            'below_map' => '',
            'footer' => '<p class="ql-align-center">Copyright 2021 - Global DNS PHP</p>'
        ],
        'find_btn' => [
            'text' => 'Find',
            'color' => '#F3DF00',
            'text_color' => '#000000'
        ],
        'whois_btn' => [
            'text' => 'Lookup',
            'color' => '#F3DF00',
            'text_color' => '#000000'
        ],
        'default_dns' => 'A',
        'enable_logs' => false,
        'show_dark_mode' => true,
        'recaptcha' => [
            'enabled' => false,
            'site_key' => '',
            'secret_key' => ''
        ],
        'enable_ad_block_detector' => false,
        'timeout' => 5,
    ];

    public $success_image, $error_image, $pending_image;

    public function mount() {
        foreach ($this->state as $key => $props) {
            if ($key != 'status_images') {
                $this->state[$key] = config('app.settings.' . $key);
            }
        }
        if (Storage::exists('public/images/custom-success.png')) {
            $this->state['status_images']['success'] = Storage::url('public/images/custom-success.png');
        }
        if (Storage::exists('public/images/custom-error.png')) {
            $this->state['status_images']['error'] = Storage::url('public/images/custom-error.png');
        }
        if (Storage::exists('public/images/custom-pending.png')) {
            $this->state['status_images']['pending'] = Storage::url('public/images/custom-pending.png');
        }
    }

    public function updated() {
        $this->dispatchBrowserEvent('componentUpdated');
    }

    public function update() {
        $this->dispatchBrowserEvent('componentUpdated');
        $this->validate(
            [
                'state.font_family' => 'required',
            ],
            [
                'state.font_family' => 'Font Family is Required',
            ]
        );
        if ($this->state['recaptcha']['enabled']) {
            $this->validate(
                [
                    'state.recaptcha.site_key' => 'required',
                    'state.recaptcha.secret_key' => 'required'
                ],
                [
                    'state.recaptcha.site_key.required' => 'Site Key is Required',
                    'state.recaptcha.secret_key.required' => 'Secret Key is Required'
                ]
            );
        }
        if ($this->success_image) {
            $this->success_image->storeAs('public/images', 'custom-success.png');
        }
        if ($this->error_image) {
            $this->error_image->storeAs('public/images', 'custom-error.png');
        }
        if ($this->pending_image) {
            $this->pending_image->storeAs('public/images', 'custom-pending.png');
        }
        $settings = Setting::whereIn('key', ['font_family', 'text', 'find_btn', 'whois_btn', 'default_dns', 'enable_logs', 'show_dark_mode', 'recaptcha', 'enable_ad_block_detector'])->get();
        foreach ($settings as $setting) {
            $setting->value = serialize($this->state[$setting->key]);
            $setting->save();
        }
        $this->emit('saved');
    }

    public function render() {
        return view('backend.settings.configuration');
    }
}
