<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Services\Util;
use App\Services\Whois;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller {

    public function servers() {
        return Server::where('is_active', true)->get();
    }

    public function dns($key, $domain, $type, $id) {
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
                $result = Util::getRecords($domain, $type, $server->url);
            }
            if ($result) {
                Util::saveLogs($domain, $type, $result, $id);
                return $result;
            }
            return response('shell_exec is disabled', 503);
        }
    }

    public function whois($key, $domain) {
        $whois = new Whois($domain);
        return $whois->info();
    }
}
