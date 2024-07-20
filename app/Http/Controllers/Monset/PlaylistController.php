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
        $playlists = Playlist::getPublic()->paginate();

        return response()->json($playlists);
    }

    /**
     * Display a private listing of the resource.
     */
    public function private()
    {
        $playlists = Playlist::getPrivate()->paginate();

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

    public function show(Request $request)
    {
        $playlist = Playlist::find($request->id);

        if ($playlist->creator_id !== null and auth()->user() === null) {
            abort(403);
        }elseif ($playlist->creator_id !== null){
            if (auth()->user()->cannot('view', $playlist)) {
                abort(403);
            }
        }


        return response()->json([
            'playlist' => $playlist,
            'clips' => $playlist->clips()->paginate()
        ]);
    }
}
