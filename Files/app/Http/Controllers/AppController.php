<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Server;
use App\Models\Setting;
use App\Services\DigParser;
use App\Services\Util;
use App\Services\Whois;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use stdClass;

class AppController extends Controller {

    /**
     * Public function to view MAIN App 
     * 
     * @since 1.0.0
     */

    public function app() {
        if (config('app.settings.ad_block_detector_filename') == null || Setting::where('key', 'ad_block_detector_filename')->where('updated_at', '<', Carbon::now()->subDays(3))->count() > 0) {
            $this->updateAdBlockDetector();
        }
        if (file_exists(public_path('storage')) !== TRUE) {
            Artisan::call('storage:link');
        }
        $menus = Menu::where('status', true)->where('parent_id', null)->orderBy('order')->get();
        $servers = Server::select('id', 'name', 'lat', 'long', 'country')->where('is_active', true)->get();
        return view('app')->with(compact('servers', 'menus'));
    }

    /**
     * Public function for Pages Module
     * 
     * @since 2.0.0
     */

    public function page($slug = '', $inner = '') {
        $menus = Menu::where('status', true)->where('parent_id', null)->orderBy('order')->get();
        if ($inner && $slug != 'whois') {
            $parent = Page::select('id')->where('slug', $slug)->first();
            if ($parent) {
                $parent_id = $parent->id;
            } else {
                return abort(404);
            }
        }
        $page = Page::where('slug', ($inner && $slug != 'whois') ? $inner : $slug)->where('parent_id', isset($parent_id) ? $parent_id : null)->first();
        if ($page) {
            $header = $page->header;
            foreach ($page->meta ? unserialize($page->meta) : [] as $meta) {
                if ($meta['name'] == 'canonical') {
                    $header .= '<link rel="canonical" href="' . $meta['content'] . '" />';
                } else if (str_contains($meta['name'], 'og:')) {
                    $header .= '<meta property="' . $meta['name'] . '" content="' . $meta['content'] . '" />';
                } else {
                    $header .= '<meta name="' . $meta['name'] . '" content="' . $meta['content'] . '" />';
                }
            }
            $page->header = $header;
            if ($page->slug == 'whois') {
                $content = explode('[split]', $page->content, 2);
                $page->content = new stdClass;
                $page->content->one = $content[0];
                $page->content->two = isset($content[1]) ? $content[1] : '';
                if ($inner) {
                    $page->domain = $inner;
                    $whois = new Whois($page->domain);
                    $response = $whois->info();
                    $page->whois = str_replace(array("\r\n", "\n"), '<br>', $response);
                }
            }
            return view('page')->with(compact('page', 'menus'));
        }
        return abort(404);
    }

    /**
     * Whois Submit
     * 
     * @since 2.0.0
     */
    public function fetchWhois(Request $request) {
        if ($request->has('domain')) {
            $domain = $request->domain;
            return redirect()->route('page', [
                'slug' => 'whois',
                'inner' => $domain
            ]);
        }
        return redirect()->route('page', [
            'slug' => 'whois'
        ]);
    }

    /**
     * Public function to check for DNS Records
     * 
     * @since 1.0.0
     */
    public function fetchRecords($domain, $type, $id) {
        $server = Server::where('is_active', true)->findOrFail($id);
        if (strpos($server->url, 'http') !== false) {
            $response = Http::post($server->url, [
                'url' => $domain,
                'type' => $type
            ]);
            if ($response->status() == 200) {
                $result = $response->body();
                Util::saveLogs($domain, $type, $result, $id);
                return $result;
            }
            return response(400);
        } else {
            if ($type == "PTR") {
                $result = gethostbyaddr($domain);
            } else {
                $data = Util::getRecords($domain, $type, $server->url);
                $result = '';
                foreach ($data->answer as $key => $answer) {
                    $result .= ($key ? '<br>' : '') . $answer->data;
                }
            }
            if ($result) {
                Util::saveLogs($domain, $type, $result, $id);
                return $result;
            }
            return response('shell_exec is disabled', 503);
        }
    }

    /**
     * Update Ad Block Detector File Name
     */
    private function updateAdBlockDetector() {
        try {
            $detector = Http::get('https://www.detectadblock.com');
            $filename = $this->getStringBetween($detector, '&lt;script src="/', '" type="text/javascript"&gt;');
            $setting = Setting::where('key', 'ad_block_detector_filename')->first();
            if ($setting) {
                $setting->value = serialize($filename);
                $setting->save();
            } else {
                $setting = Setting::create([
                    'key' => 'ad_block_detector_filename',
                    'value' => serialize($filename)
                ]);
            }
            if (config('app.settings.ad_block_detector_filename') != $filename) {
                $js = 'var e=document.createElement("div");e.id="fIeuXHFgWLES",e.classList.add("hidden"),document.body.appendChild(e);';
                if (config('app.settings.ad_block_detector_filename')) {
                    Storage::disk('public')->delete('js/' . config('app.settings.ad_block_detector_filename'));
                }
                Storage::disk('public')->put('js/' . $filename, $js);
            }
        } catch (Exception $e) {
            Setting::where('key', 'ad_block_detector_filename')->update(['updated_at' => Carbon::now()]);
        }
    }

    /**
     * Get data between 2 strings
     */
    private function getStringBetween($string, $start, $end) {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}
