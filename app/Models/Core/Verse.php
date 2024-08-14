<?php

namespace App\Models\Core;

use App\Models\Monset\Clip;
use App\Models\Monset\ClipHasVerses;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Verse extends Model
{
    use HasFactory;

    protected function orderedId(): Attribute{
        return Attribute::get(fn() => $this->surah_id . ':' . $this->order);
    }

    public function clips(): Builder {
        $clipsIds = ClipHasVerses::where('start_verse_id', '<=', $this->id)->where('end_verse_id', '>=', $this->id)->pluck('clip_id');
        return Clip::whereIn('id', $clipsIds);
    }
}
