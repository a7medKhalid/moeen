<?php

namespace App\Models\Monset;

use App\Enums\Monset\Segment\Type;
use App\Models\Core\Verse;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Segment extends Model
{
    use HasFactory;

    protected $casts = [
//        'type' => Type::class
    ];

    public function audioFile(): BelongsTo {
        return $this->belongsTo(AudioFile::class);
    }

    public function verse(): BelongsTo{
//        if ($this->type !== Type::verse) throw new Exception('Segment is not a verse');
        return $this->belongsTo(Verse::class, 'type_id');
    }
}
