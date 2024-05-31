<?php

namespace App\Models\Monset;

use App\Models\Core\Verse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clip extends Model
{
    use HasFactory;

    public function verses(): HasMany{
        return $this->hasMany(ClipHasVerses::class);
    }

    public function playlists(): BelongsToMany {
        return $this->belongsToMany(Playlist::class, 'playlist_has_clips');
    }
}
