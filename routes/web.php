<?php

use App\Models\Monset\AudioFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $url = 'https://api.qurancdn.com/api/qdc/audio/reciters/7/audio_files?chapter=1&segments=true';

    try {
        $response = Http::get($url);

        if ($response->successful()) {
            // If the response is successful, you can return the data or process it as needed
            $data = $response->json()['audio_files'][0];
            $audio_url = $data['audio_url'];
            $verse_timings = $data['verse_timings'];


            $reciter = \App\Models\Monset\Reciter::firstOrCreate([
                'name' => 'mshary'
            ]);

            $surah = \App\Models\Core\Surah::firstOrCreate([
                'name' => 'fatehah',
                'order' => 1
            ]);

            $audioFile = AudioFile::firstOrCreate([
                'url' => $audio_url,
                'reciter_id' => $reciter->id
            ]);

            $counter = 0;
            foreach ($verse_timings as $timing){
                $counter++;

                $verse = \App\Models\Core\Verse::firstOrCreate([
                    'order' => $counter,
                    'surah_id' => 1
                ]);

                $audioFile->segments()->firstOrCreate([
                    'start_time' => $timing['timestamp_from'],
                    'end_time' => $timing['timestamp_to'],
                    'type' => \App\Enums\Monset\Segment\Type::verse,
                    'type_id' => $verse->id
                ]);
            }

            return response()->json($data);
        } else {
            // Handle the case where the response is not successful
            return response()->json(['error' => 'Failed to fetch audio files'], $response->status());
        }
    } catch (\Exception $e) {
        // Handle any exceptions that occur during the request
        return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
    }

//    return view('welcome');
});
