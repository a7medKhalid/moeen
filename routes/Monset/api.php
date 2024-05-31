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

    foreach ($verses as $verse) {

        foreach ($verse->getRelatedAudioFiles() as $segment) {
            $segments[] = $segment;
        }
    }

    //TODO: join segments with same url add last end time

    // Group objects by URL
    $grouped_by_url = [];

    foreach ($segments as $item) {
        $url = $item["url"];
        if (!isset($grouped_by_url[$url])) {
            $grouped_by_url[$url] = [
                "start" => $item["start"],
                "end" => $item["end"]
            ];
        } else {
            $grouped_by_url[$url]["start"] = min($grouped_by_url[$url]["start"], $item["start"]);
            $grouped_by_url[$url]["end"] = max($grouped_by_url[$url]["end"], $item["end"]);
        }
    }

// Create new array with combined objects
    $combined_data = [];
    $id_counter = 1;

    foreach ($grouped_by_url as $url => $times) {
        $combined_data[] = [
            "id" => $id_counter,
            "start" => $times["start"],
            "end" => $times["end"],
            "url" => $url
        ];
        $id_counter++;
    }


    return response()->json([
        'id' => $clip->id,
        'title' => $clip->title,
        'description' => $clip->descrbtion,
        'segments' => $combined_data,
    ]);
});
