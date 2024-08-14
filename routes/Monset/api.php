<?php

use App\Http\Controllers\Monset;
use App\Models\Monset\Clip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(Monset\PlaylistController::class)->prefix('playlists')->group(function () {

    Route::middleware('auth')->group(function (){
        Route::get('private',  'private');
        Route::post('playlists',  'create');
        Route::put('playlists',  'update');
        Route::delete('playlists',  'delete');
    });
    Route::get('',  'index');
    Route::get('{id}',  'show');

});

Route::get('clips', function () {
    return response()->json(\App\Models\Monset\Clip::all());
});

Route::controller(Monset\ClipsController::class)->prefix('clips')->group(function () {
    Route::get('{id}', 'show');
    Route::get('{id}/audio-files', 'audioFiles');
});

Route::controller(Monset\SearchController::class)->prefix('search')->group(function () {
    Route::get('', 'search');
});

Route::controller(Monset\FeedController::class)->prefix('feed')->group(function () {
    Route::get('',  'index');
});


Route::get('test' , function(){
    return \App\Models\Monset\Reciter::pluck('name');
});
