<?php

use App\Models\Monset\Clip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('clips', function () {
    return response()->json(\App\Models\Monset\Clip::all());
});

Route::get('clips/{id}', function ($id) {
    $clip = Clip::find($id);
    $verses = $clip->verses;
    $segments = [];

    foreach ($verses as $verse){
        $segments[] = $verse->getRelatedAudioFiles();
    }

    return response()->json([
        'clip' => $clip,
        'verses' => $verses,
        'segments' => $segments,
    ]);
});
