<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Casa de los Granos API',
        'version' => '1.0.0'
    ]);
});

