<?php

namespace Database\Seeders;

use App\Models\Monset\Clip;
use App\Models\Monset\ClipHasVerses;
use App\Models\Monset\Playlist;
use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicsClipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        $topicsPlaylist = Playlist::create([
//            'title' => [
//                'ar' => 'مواضيع القرآن',
//                'en' => 'Quran Topicsَ,'
//            ],
//        ]);

        $playlistTopics = Topic::doesntHave('verses')->get();

        foreach ($playlistTopics as $playlistTopic){
            $topicPlaylist = Playlist::create([
                'title' => [
                    'ar' => $playlistTopic->getPhrase('title', 'ar'),
                    'en' => '',
                ],
            ]);

            $clipTopics = Topic::where('parent_id', $playlistTopic->apiId)->get();

            foreach ($clipTopics as $clipTopic)
            {
                $clip = Clip::create([
                    'title' => [
                        'ar' => $clipTopic->getPhrase('title', 'ar'),
                        'en' => '',
                    ],
                ]);

                $topicPlaylist->clips()->attach($clip);

                $topicVerses = $clipTopic->verses->toArray();
                $counter = 0;
                $versesBuffer = [];
                foreach ($topicVerses as $topicVerse){
                    if ((int)($topicVerses[$counter + 1]['id']?? 1000) - (int)$topicVerse['id'] === 1) {
                        $versesBuffer[] = $topicVerse;
                    }else{
                        $versesBuffer[] = $topicVerse;

                        $count = count($versesBuffer) - 1;
                        ClipHasVerses::create([
                            'start_verse_id' => $versesBuffer[0]['id'],
                            'end_verse_id' => $versesBuffer[$count]['id'],
                            'order' => $counter + 1,
                            'clip_id' => $clip->id,
                        ]);
                        $versesBuffer = [];
                    }

                    ++$counter;

                }


            }
        }
    }
}
