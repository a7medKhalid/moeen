<?php

namespace Database\Seeders;

use App\Models\Core\Surah;
use App\Models\Monset\Clip;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SurahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($c = 1; $c < 115; $c++) {

            $surah = Surah::find($c);

            $first_verse = $surah->verses->first();
            $last_verse = $surah->verses->last();

            $clip = Clip::create([
                'title' => $c,
            ]);

            $clip->attach($surah->id, [
                'start_verse_id' => $first_verse,
                'end_verse_id' => $last_verse,
                'audio_file_id' => 1
                ]);

            $clip->save();


        }
    }
}
