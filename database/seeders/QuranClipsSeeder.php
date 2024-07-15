<?php

namespace Database\Seeders;

use App\Models\Core\Surah;
use App\Models\Monset\Clip;
use App\Models\Monset\Playlist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuranClipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $playlist = Playlist::create([
            'title' => [
                'ar' => 'القرآن كاملاً',
                'en' => 'Full Quran',
            ],
            'description' => [
                'ar' => 'القرآن الكريم كاملاً',
                'en' => 'Full Quran',
            ],
        ]);

        foreach (Surah::all() as $surah){
            $clip = Clip::create([
                'title' => [
                    'en' => trans('surahs.' . $surah->id, [], 'en'),
                    'ar' => __('surahs.' . $surah->id, [], 'ar'),
                ],
                'description' => [
                    'en' => __('surahs.' . $surah->id, [], 'en'),
                    'ar' => __('surahs.' . $surah->id, [], 'ar'),
                ],
            ]);

            $clip->verses()->create([
                'start_verse_id' => $surah->verses->first()->id,
                'end_verse_id' => $surah->verses->last()->id,
                'order' => 1,
            ]);

            $playlist->clips()->attach($clip);
        }
    }
}
