<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/somework', function () {
   dd(\App\Models\Monset\Clip::first());
});

require __DIR__.'/auth.php';
