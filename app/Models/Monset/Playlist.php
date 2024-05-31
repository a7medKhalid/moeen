<?php

namespace App\Models\Monset;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Playlist extends Model
{
    use HasFactory;

    public function clips(): BelongsToMany {
        return $this->belongsToMany(Clip::class, 'playlist_has_clips');
    }
}
