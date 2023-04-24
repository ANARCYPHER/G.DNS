<?php

namespace App\Http\Livewire\Backend\Settings;

use Livewire\Component;
use App\Models\Setting;

class Advance extends Component {
    /**
     * Components State
     */
    public $state = [
        'global' => [
            'css' => '',
            'js' => '',
            'header' => '',
            'footer' => ''
        ],
        'api_keys' => [],
        'map_fail_reloader' => false
    ];

    public function mount() {
        $this->state['global'] = config('app.settings.global');
        $this->state['api_keys'] = config('app.settings.api_keys', []);
        $this->state['map_fail_reloader'] = config('app.settings.map_fail_reloader');
    }

    public function add() {
        array_push($this->state['api_keys'], $this->random());
    }

    public function remove($key) {
        unset($this->state['api_keys'][$key]);
    }

    private function random($length = 32) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($characters), 0, $length);
    }

    public function update() {
        $this->validate(
            [
                'state.api_keys.*' => 'required'
            ],
            [
                'state.api_keys.*.required' => 'API Key field is Required'
            ]
        );
        $settings = Setting::whereIn('key', ['global', 'api_keys', 'map_fail_reloader'])->get();
        foreach ($settings as $setting) {
            $setting->value = serialize($this->state[$setting->key]);
            $setting->save();
        }
        $this->emit('saved');
    }

    public function render() {
        return view('backend.settings.advance');
    }
}
