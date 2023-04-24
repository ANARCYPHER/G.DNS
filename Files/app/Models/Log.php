<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model {
    use HasFactory;

    public static function stats() {
        $stats = [
            'logs_enabled' => config('app.settings.enable_logs'),
            'logs_count' => 0,
            'domain' => '-',
            'type' => '-',
            'servers' => 0
        ];
        $stats['logs_count'] = Log::count();
        if ($stats['logs_count'] > 0) {
            $stats['domain'] = Log::select('domain')->groupBy('domain')->orderByRaw('COUNT(*) DESC')->limit(1)->first()->domain;
            $stats['type'] = Log::select('type')->groupBy('type')->orderByRaw('COUNT(*) DESC')->limit(1)->first()->type;
        }
        $stats['servers_count'] = Server::count();
        return $stats;
    }
}
