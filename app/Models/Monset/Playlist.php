<?php

namespace App\Models\Monset;

use App\Models\Monset\Traits\PlaylistHasData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Playlist extends Model
{
    use HasFactory, PlaylistHasData;
    public function clips(): BelongsToMany {
        return $this->belongsToMany(Clip::class, 'playlist_has_clips');
    }
}
