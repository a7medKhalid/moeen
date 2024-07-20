<?php

namespace App\Models\Monset;

use App\Models\Monset\Traits\PlaylistHasData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use LaraZeus\TranslatablePro\Casts\PhrasesCast;
use LaraZeus\TranslatablePro\Facades\TranslatablePro;
use LaraZeus\TranslatablePro\Models\Concerns\HasPhrases;

class Playlist extends Model
{
    use HasFactory, PlaylistHasData;
    use HasPhrases;

    protected $casts = [
        'title' => PhrasesCast::class,
        'description' => PhrasesCast::class,
    ];

    public function clips(): BelongsToMany {
        return $this->belongsToMany(Clip::class, 'playlist_has_clips');
    }
}
