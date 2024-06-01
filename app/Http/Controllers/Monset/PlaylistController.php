<?php

namespace App\Http\Controllers\Monset;

use App\Http\Controllers\Controller;
use App\Models\Monset\Playlist;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $playlists = Playlist::getPublic()->with('clips')->paginate();

        return response()->json($playlists);
    }

    /**
     * Display a private listing of the resource.
     */
    public function private()
    {
        $playlists = Playlist::getPrivate()->with('clips')->paginate();

        return response()->json($playlists);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        //TODO: @ahmed create validator class that can be used in controller and filament
//        $request->validate()

        return response()->json(Playlist::createPlaylist($request->data));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //TODO: @ahmed create validator class that can be used in controller and filament
//        $request->validate()
        return response()->json(Playlist::updatePlaylist($request->data));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return response()->json(Playlist::deletePlaylist($request->data));
    }
}
