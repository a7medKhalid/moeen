<?php

namespace App\Models\Monset;

use App\Models\Monset\Traits\AudioFileHasData;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AudioFile extends Model
{
    use HasFactory;
    use AudioFileHasData;

    protected $with = ['reciter'];

    public function reciter(): BelongsTo{
        return $this->belongsTo(Reciter::class);
    }
    public function segments(): HasMany {
        return $this->hasMany(Segment::class);
    }
}
