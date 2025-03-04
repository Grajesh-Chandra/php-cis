<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginRegisterController;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::get('/claim-completed', function () {
    return view('completed');
});

Route::get('/cis', function () {
    return view('cis');
});

Route::get('/accounts', function () {
    return view('accounts');
});

Route::get('/pdf', function () {
    return view('pdf');
});

Route::get('/verify', function () {
    return view('verify');
});

Route::get('/iota', function (Request $request) {

    $iotaConfig = config('services.affinidi_iota');
    $response_code = $request->query('response_code');
    return view(
        'iota',
        [
            'config_id' => $iotaConfig["config_id"],
            'avvanz_query_id' => $iotaConfig["avvanz_query_id"],
            'response_code' => $response_code,
        ]
    );
});

Route::controller(LoginRegisterController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::get('/home', 'home')->name('home');
    Route::get('/logout', 'logout')->name('logout');
    Route::get('/login/affinidi', 'affinidiLogin')->name('affinidi-login');
    Route::get('/login/affinidi/callback', 'affinidiCallback')->name('affinidi-callback');
});
