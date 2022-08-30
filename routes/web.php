<?php

use App\Robot\SimpleRecognizeTopic;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {

    $simpleRecognize = new SimpleRecognizeTopic();
    $simpleRecognize->setInput('
    Здравей! Как си днес? Какво правиш? От къде си между другото? Аз слушам музика
    ');
    $response = $simpleRecognize->getResponse();

    dd($response);

});
