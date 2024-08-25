<?php

namespace App\Models\Monset;

use App\Models\Core\Verse;
use App\Models\Monset\Traits\ClipHasData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use LaraZeus\TranslatablePro\Casts\PhrasesCast;
use LaraZeus\TranslatablePro\Facades\TranslatablePro;
use LaraZeus\TranslatablePro\Models\Concerns\HasPhrases;

class Clip extends Model
{
    use HasFactory;
    use HasPhrases;
    use ClipHasData;

    protected $casts = [
        'title' => PhrasesCast::class,
        'description' => PhrasesCast::class,
    ];

    public function verses(): HasMany {
        return $this->hasMany(ClipHasVerses::class);
    }

    public function playlists(): BelongsToMany {
        return $this->belongsToMany(Playlist::class, 'playlist_has_clips');
    }
}
