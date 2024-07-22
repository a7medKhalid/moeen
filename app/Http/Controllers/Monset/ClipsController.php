<?php

namespace App\Http\Controllers\Monset;

use App\Http\Controllers\Controller;
use App\Models\Monset\AudioFile;
use App\Models\Monset\Clip;
use Illuminate\Database\Eloquent\Builder;

class ClipsController extends Controller
{
    public function audioFiles($id){
        $clip = Clip::find($id);

        //get audio files that has segments for all verses
        $audioFiles = AudioFile::getClipAvailableAudioFiles($clip)->get();

        return response()->json($audioFiles);

    }
    public function show($id){
        $clip = Clip::find($id);
        $audioFileId = request()->get('audioFileId');
        $verses = $clip->verses;
        $segments = [];

        foreach ($verses as $verse) {
            $audioFileId =  $audioFileId ?? $verse->audio_file_id;
            if ($audioFileId === null) $audioFileId = AudioFile::getClipAvailableAudioFiles($clip)->first()->id;

            foreach ($verse->getRelatedAudioFiles($audioFileId) as $segment) {
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
    }
}
