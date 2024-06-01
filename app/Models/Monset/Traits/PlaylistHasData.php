<?php

namespace App\Models\Monset\Traits;

use App\Models\Monset\Playlist;
use Illuminate\Database\Eloquent\Builder;

trait PlaylistHasData
{
    private static string $model = Playlist::class;

    public static function getPrivate(): Builder {
        return self::$model::where('creator_id', auth()->user()->id);
    }

    public static function getPublic(): Builder {
        return self::$model::where('creator_id', null);
    }

    public static function createPlaylist(array $data): Playlist {
        $playlist = self::$model::create(
            [
                'title' => $data['title'],
                'description' => $data['description'],

            ]
        );

        $playlist = static::updateClips($playlist, $data['clips']);

        $playlist->save();


        return $playlist;
    }

    public static function updatePlaylist(array $data): Playlist {

        $playlist = static::$model::find($data['playlist_id']);

        if (auth()->user()->cannot('update', $playlist)){
            abort(403);
        }

        $playlist = $playlist::update(
            [
                'title' => $data['title'],
                'description' => $data['description'],

            ]
        );

        $playlist = static::updateClips($playlist, $data['clips']);

        $playlist->save();


        return $playlist;
    }

    private static function updateClips(Playlist $playlist, array $clips): Playlist
    {
        $playlist->clips()->sync($clips);

        return $playlist;
    }

    public static function deletePlaylist(array $data): Playlist {

        $playlist = static::$model::find($data['playlist_id']);

        if (auth()->user()->cannot('delete', $playlist)){
            abort(403);
        }

        return $playlist::delete();
    }

}
