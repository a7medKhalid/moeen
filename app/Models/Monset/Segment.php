<?php

namespace App\Models\Monset;

use App\Enums\Monset\Segment\Type;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Segment extends Model
{
    use HasFactory;

    protected $casts = [
//        'type' => Type::class
    ];

    public function audioFile(): BelongsTo {
        return $this->belongsTo(AudioFile::class);
    }
}
