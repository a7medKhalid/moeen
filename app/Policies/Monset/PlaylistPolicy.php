<?php

namespace App\Policies\Monset;

use App\Models\Monset\Playlist;
use Illuminate\Foundation\Auth\User;

class PlaylistPolicy
{

    public function update(User $user, Playlist $playlist): bool{
        return $playlist->creator_id === $user->id;
    }

    public function delete(User $user, Playlist $playlist): bool{
        return $this->update($user, $playlist);
    }
}
