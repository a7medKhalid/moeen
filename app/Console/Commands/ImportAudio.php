<?php

namespace App\Console\Commands;

use App\Models\Monset\AudioFile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportAudio extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-audio';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->getAudioFiles();
    }

    public function getAudioFiles()
    {
        for ($i = 1; $i < 115; $i++) {
            $url = 'https://api.qurancdn.com/api/qdc/audio/reciters/7/audio_files?chapter=' . $i .'&segments=true';

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
                        'name' => $i,
                        'order' => $i
                    ]);

                    $audioFile = AudioFile::firstOrCreate([
                        'url' => $audio_url,
                        'reciter_id' => $reciter->id
                    ]);

                    $counter = 0;
                    foreach ($verse_timings as $timing) {
                        $counter++;

                        $verse = \App\Models\Core\Verse::firstOrCreate([
                            'order' => $counter,
                            'surah_id' => $surah->id
                        ]);

                        $audioFile->segments()->firstOrCreate([
                            'start_time' => $timing['timestamp_from'],
                            'end_time' => $timing['timestamp_to'],
                            'type' => \App\Enums\Monset\Segment\Type::verse,
                            'type_id' => $verse->id
                        ]);
                    }

                }
            } catch (\Exception $e) {
            }
        }
    }
}
