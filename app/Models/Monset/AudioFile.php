<?php

namespace App\Models\Monset;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AudioFile extends Model
{
    use HasFactory;

    public function segments(): HasMany {
        return $this->hasMany(Segment::class);
    }
}
