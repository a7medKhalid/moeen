<?php

namespace Database\Seeders;

use App\Models\Monset\AudioFile;
use App\Models\Monset\Reciter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RenameReciters extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //take first audio file of every reciter_id
        $audioFiles = AudioFile::
            all()
            ->unique('reciter_id');

        //update reciter name form url after /qdc/
        foreach ($audioFiles as $audioFile) {
            $reciterId = $audioFile->reciter_id;
            $url = $audioFile->url;
            $reciterName = explode('/', $url)[4];
            Reciter::where('id', $reciterId)->update(['name' => $reciterName]);
        }

    }
}
