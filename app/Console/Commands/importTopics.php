<?php

namespace App\Console\Commands;

use App\Models\Core\Verse;
use App\Models\Topic;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class importTopics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-topics';

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
        $this->getTopics();
    }

    public function getTopics()
    {
        $url = 'https://api.quranpedia.net/v1/topics';

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                // If the response is successful, you can return the data or process it as needed
                $data = $response->json();

                $counter = 0;
                foreach ($data as $datum) {
                    ++$counter;

                    $versesKeys = explode(',', $datum['ayahs']);
                    if (empty($versesKeys[0]) ) continue;

                    $topic = Topic::create([
                       'title' => [
                           'ar' => $datum['name'],
                           'en' => '',
                       ],
                       'parent_id' => $datum['parent_id'],
                   ]);

                    foreach ($versesKeys as $verse){
                        $verse = explode(':', $verse);
                        $surah = (int)$verse[0];
                        $verse = (int)$verse[1];
                        $verse = Verse::where('surah_id', $surah)->where('order', $verse)->first();

                        $topic->verses()->attach($verse);
                    }

                    $this->info('The command was successful! ' . $counter);

                }


            }
        } catch (\Exception $e) {
            $this->error('The command was not successful! ' . $e);
        }
    }

}
