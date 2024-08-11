<?php

namespace App\Models\Core;

use App\Models\Monset\Clip;
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

    public function clips(): BelongsToMany{
        return $this->belongsToMany(Clip::class, 'clip_has_verses');
    }
}
