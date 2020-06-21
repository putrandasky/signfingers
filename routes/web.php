<?php

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

Route::get('', function () {
    // App::setLocale($locale);
    return view('apps.website');
});
Route::get('/id', function () {
    App::setLocale('id');
    return view('apps.website');
});
Route::get('/sign-file', function () {
    return view('apps.app');
});
Route::get('/sitemap', function () {
    return view('sitemap.index');
});
Route::get('/sitemap.xml', function () {
    return view('sitemap.index');
});
Route::get('/signer', 'Signer\SignerController@index');
Route::post('/generate', 'Signer\SignerController@generate');
