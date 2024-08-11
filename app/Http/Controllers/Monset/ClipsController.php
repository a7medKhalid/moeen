<?php

namespace App\Http\Controllers\Monset;

use App\Http\Controllers\Controller;
use App\Models\Monset\AudioFile;
use App\Models\Monset\Clip;
use App\Models\Monset\Segment;
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
            $audio_file_id = $item['audio_file_id'];
            $url = $item["url"];
            if (!isset($grouped_by_url[$url])) {
                $grouped_by_url[$url] = [
                    "start" => $item["start"],
                    "end" => $item["end"],
                    'audio_file_id' => $audio_file_id,
                ];
            } else {
                $grouped_by_url[$url]["start"] = min($grouped_by_url[$url]["start"], $item["start"]);
                $grouped_by_url[$url]["end"] = max($grouped_by_url[$url]["end"], $item["end"]);
                $grouped_by_url[$url]["audio_file_id"] = $audio_file_id;
            }
        }

        // Create new array with combined objects
        $combined_data = [];
        $id_counter = 1;

        foreach ($grouped_by_url as $url => $times) {
            $segments = Segment::where('audio_file_id', $audioFileId)->where('end_time', '<=',$times["end"] )->get();
            $segments = $segments->map(function ($segment) {
                return [
                    'start' => $segment->start_time,
                    'end' => $segment->end_time,
                    'verseOrderedId' => $segment->verse?->orderedId,
                ];
            });
            $combined_data[] = [
                "id" => $id_counter,
                "start" => $times["start"],
                "end" => $times["end"],
                "url" => $url,
                'audio_file_id' => $times['audio_file_id'],
                'segments' => $segments,
            ];
            $id_counter++;
        }


        return response()->json([
            'id' => $clip->id,
            'title' => $clip->title,
            'description' => $clip->descrbtion,
            'audioFiles' => $combined_data,
        ]);
    }
}
