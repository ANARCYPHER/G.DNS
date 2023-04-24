<?php

namespace App\Services;

use App\Models\Log;
use App\Models\Page;

class Util {
    public static function saveLogs($domain, $type, $result, $server_id) {
        try {
            if (config('app.settings.enable_logs')) {
                $log = new Log();
                $log->domain = $domain;
                $log->type = $type;
                $log->result = $result;
                $log->server_id = $server_id;
                $log->save();
            }
        } catch (\Exception $e) {
        }
    }

    public static function getRecords($domain, $type, $ip) {
        if (!Util::isShellExecEnabled()) {
            return false;
        }
        $response = shell_exec('dig @' . $ip . ' ' . $domain . ' ' . $type);
        $parser = new DigParser;
        return $parser->parse($response);
    }

    public static function isShellExecEnabled() {
        if (trim(@shell_exec('echo foobar')) == 'foobar') {
            return true;
        }
        return false;
    }
}
