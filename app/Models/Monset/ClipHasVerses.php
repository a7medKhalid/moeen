<?php

namespace App\Models\Monset;

use App\Enums\Monset\Segment\Type;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ClipHasVerses extends Pivot
{
    use HasFactory;

    public function getTable()
    {
        return 'clip_has_verses';
    }

    public function getRelatedAudioFiles(){
        $segments = Segment::where('type', Type::verse)->where(function ($query)  {
            $query->where('type_id', $this->start_verse_id)
                ->orWhere('type_id', $this->start_verse_id);
        })->get();

        return $segments->map(function ($segment){
           return [
               'start_time' => $segment->start_time,
               'end_time' => $segment->end_time,
               'audio_file' => $segment->audioFile
           ];
        });
    }
}
