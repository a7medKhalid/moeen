<?php

namespace App\Console\Commands;

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
        $url = 'https://api.qurancdn.com/api/qdc/audio/reciters/7/audio_files?chapter=1&segments=true';

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                // If the response is successful, you can return the data or process it as needed
                $data = $response->json();
                return response()->json($data);
            } else {
                // Handle the case where the response is not successful
                return response()->json(['error' => 'Failed to fetch audio files'], $response->status());
            }
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the request
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
