<?php

namespace App\Models\Monset;

use App\Enums\Monset\Segment\Type;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ClipHasVerses extends Pivot
{
    use HasFactory;

    public function getTable()
    {
        return 'clip_has_verses';
    }

    public function defaultAudioFile(): BelongsTo {
        return $this->belongsTo(AudioFile::class);
    }

    public function getRelatedAudioFiles(){
        $segments = Segment::where('type', Type::verse)->whereBetween('type_id', [$this->start_verse_id, $this->end_verse_id])->get();

        return $segments->map(function ($segment){
           return [
               'id' => $segment->id,
               'start' => (int)$segment->start_time,
               'end' => (int)$segment->end_time,
               'url' => $segment->audioFile?->url
//               'url' => $segment->defaultAudioFile?->url,
           ];
        });
    }


}
