<?php

namespace App\Http\Controllers\Monset;

use App\Http\Controllers\Controller;
use App\Models\Monset\Playlist;

class FeedController extends Controller
{
    public function index()
    {
        $playlists = Playlist::getPublic()
            ->with(['clips' => function($query) {
                $query->take(10);
            }])
            ->get();
        return $playlists;
    }
}

