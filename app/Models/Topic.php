<?php

namespace App\Models;

use App\Models\Core\Verse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use LaraZeus\TranslatablePro\Casts\PhrasesCast;
use LaraZeus\TranslatablePro\Models\Concerns\HasPhrases;

class Topic extends Model
{
    use HasFactory;
    use HasPhrases;

    protected $casts = [
        'title' => PhrasesCast::class,
    ];

    public function verses(): BelongsToMany {
        return $this->belongsToMany(Verse::class, 'topic_has_verses')
                    ->orderByPivot('verse_id');
    }
}
