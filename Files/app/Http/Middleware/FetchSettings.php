<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;

class FetchSettings {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $view = 'user') {
        $block = [
            'user' => ['license_key', 'recaptcha', 'api_keys', 'version']
        ];
        $settings = file_exists(storage_path('installed')) ? Setting::get() : [];
        foreach ($settings as $setting) {
            if (isset($block[$view]) && in_array($setting->key, $block[$view])) {
                continue;
            }
            config([
                'app.settings.' . $setting->key => unserialize($setting->value)
            ]);
        }
        return $next($request);
    }
}
