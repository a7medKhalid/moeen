<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/suggestions', function (Request $request){
    $request->validate([
        'name' => 'required|string',
        'email' => 'nullable|email',
        'title' => 'required|string',
        'content' => 'required|string'
    ]);

    $suggestion = \App\Models\Suggestion::create($request->all());

    return response()->json($suggestion, 201);
});
