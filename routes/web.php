<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return response('<h1>Hello World</h1>', 200)
        ->header('Content-Type', 'text/html')
        ->header('X-Custom-Header', 'Hello World');
});

Route::get('/post/{id}', function ($id) {
    return response("Post ID: {$id}", 200);
})->where('id', '[0-9]+');

Route::get('/search', function (Request $request) {
    dd($request);
});
Route::get('/user', function (Request $request) {
    dd($request->name);
});
