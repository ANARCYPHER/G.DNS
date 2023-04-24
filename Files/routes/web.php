<?php

use App\Http\Controllers\AppController;
use App\Models\Log;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Installer Routes
Route::get('/installer', function () {
    if (file_exists(storage_path('installed'))) {
        return redirect()->route('app');
    } else {
        return view('installer.index');
    }
})->name('installer');

Route::middleware(['verify.install', 'fetch.settings:user'])->group(function () {
    Route::get('/', [AppController::class, 'app'])->name('app');
    Route::post('/fetch/{domain}/{type}/{id}', [AppController::class, 'fetchRecords'])->name('fetch');
    Route::post('/whois', [AppController::class, 'fetchWhois'])->name('whois');

    Route::middleware(['auth:sanctum', 'verified', 'role:admin', 'fetch.settings:admin'])->prefix('admin')->group(function () {
        Route::get('/', function () {
            return redirect()->route('dashboard');
        })->name('admin');
        Route::get('/dashboard', function () {
            $stats = Log::stats();
            return view('backend.dashboard')->with('stats', $stats);
        })->name('dashboard');
        Route::get('/servers', function () {
            return view('backend.servers.index');
        })->name('servers');
        Route::get('/settings', function () {
            return view('backend.settings.index');
        })->name('settings');
        Route::get('/menu', function () {
            return view('backend.menu.index');
        })->name('menu');
        Route::get('/pages', function () {
            return view('backend.pages.index');
        })->name('pages');
        Route::get('/update', function () {
            return view('backend.update.index');
        })->name('update');
        Route::get('/logs', function () {
            $logs = Log::orderBy('id', 'DESC')->paginate(15);
            return view('backend.logs')->with('logs', $logs);
        })->name('logs');
    });

    //Page Routes
    Route::get('{slug}/{inner?}', [AppController::class, 'page'])->name('page');
});
