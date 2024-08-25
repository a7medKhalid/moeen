<?php

namespace App\Http\Controllers\Monset;

use App\Http\Controllers\Controller;
use App\Models\Monset\Playlist;

class FeedController extends Controller
{
    public function index()
    {
        $playlists = Playlist::getPublic()
            ->inRandomOrder()
            ->limit(20)
            ->with(['clips' => function($query) {
                $query
                    ->inRandomOrder()
                    ->take(10);
            }])
            ->get();
        return $playlists;
    }
}

