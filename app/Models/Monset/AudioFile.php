<?php

namespace App\Models\Monset;

use App\Models\Monset\Traits\AudioFileHasData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AudioFile extends Model
{
    use HasFactory;
    use AudioFileHasData;

    public function segments(): HasMany {
        return $this->hasMany(Segment::class);
    }
}
