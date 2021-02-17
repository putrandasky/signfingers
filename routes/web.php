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

Route::get('/sign-file', function () {
    return redirect('/digital-signature');

});
Route::get('/digital-signature', 'Signer\SignerController@view');
Route::get('/sign-request', 'Signer\SignRequestController@view');
Route::post('/sign-request', 'Signer\SignRequestController@store');
Route::get('/sign-request/sign-file/{signer_token}', 'Signer\SignRequestRespondController@view');
Route::post('/sign-request/sign-file/{signer_token}', 'Signer\SignRequestRespondController@store');
Route::get('/sign-request/token/{signer_token}', 'Signer\SignRequestRespondController@show');
Route::get('/tanda-tangan-digital', 'Signer\SignerController@view');

// Route::get('/sitemap', function () {
//     return view('sitemap.index');
// });
Route::get('/sitemap', 'Sitemap\SitemapController@index');
Route::get('/sitemap.xml', 'Sitemap\SitemapController@index');

// Route::get('/sitemap.xml', function () {
//     return view('sitemap.index');
// });
Route::get('/signer', 'Signer\SignerController@index');
Route::post('/generate', 'Signer\SignerController@generate');
Route::post('/inbox/feedback/{locale}', 'Inbox\FeedbackController@store');
Route::post('/inbox/message/{locale}', 'Inbox\MessageController@store');
Route::post('/inbox/review/{locale}', 'Inbox\ReviewController@store');
Route::get('/{locale}', 'Website\WebsiteController@homePage');
Route::get('', 'Website\WebsiteController@homePage');
