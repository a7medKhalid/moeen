<?php

namespace App\Http\Controllers\Monset;

use App\Http\Controllers\Controller;
use App\Models\Core\Verse;
use App\Models\Monset\Playlist;

class FeedController extends Controller
{
    public function index()
    {
        $playlists = Playlist::getPublic()
            ->inRandomOrder()
            ->limit(20)
            ->get()
            ->map(function ($playlist) {
                $clips = $playlist->clips()->get()->map(function ($clip) {
                    $id = $clip->verses()->first()?->start_verse_id;
                    $verse = Verse::find($id);
                    $clip->fitstVerseId = $verse->orderedId;
                    return $clip;
                });
                $playlist->clips = $clips;
                return $playlist;
            });
        return $playlists;
    }
}

