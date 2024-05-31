<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/suggestions', function (Request $request){
    $request->validate([
        'name' => 'required|string',
        'email' => 'nullable|email',
        'title' => 'required|string',
        'content' => 'required|string'
    ]);

    $suggestion = \App\Models\Core\Suggestion::create($request->all());

    return response()->json($suggestion, 201);
});


Route::prefix('monset')->group(function () {
    include 'Monset/api.php';
});


Route::prefix('auth')->group(function () {
    include 'auth.php';
});
