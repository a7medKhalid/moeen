<?php

namespace App\Http\Controllers\Monset;

use App\Http\Controllers\Controller;
use App\Models\Khatmah;
use App\Models\Monset\AudioFile;
use App\Models\Monset\Clip;
use App\Models\Monset\Segment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class KhatmahController extends Controller
{
    public function index()
    {
        $khatmas = auth()->user()->khatmas;
        return response()->json($khatmas);
    }

    // Display a specific khatmah by ID
    public function show($id)
    {
        $khatmah = auth()->user()->khatmas->findOrFail($id);

        return response()->json($khatmah);
    }

    // Create a new khatmah
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'duration' => 'nullable|integer',
            'rounds_counter' => 'integer',
            'last_round_date' => 'nullable|date',
            'bookmark_verse_id' => 'required|exists:verses,id',
            'start_verse_id' => 'required|exists:verses,id',
            'end_verse_id' => 'required|exists:verses,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $khatmah = Khatmah::create($validatedData);
        return response()->json($khatmah, 201);
    }

    // Update an existing khatmah
    public function update(Request $request, $id)
    {
        $khatmah = Khatmah::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'string',
            'duration' => 'nullable|integer',
            'rounds_counter' => 'integer',
            'last_round_date' => 'nullable|date',
            'bookmark_verse_id' => 'exists:verses,id',
            'start_verse_id' => 'exists:verses,id',
            'end_verse_id' => 'exists:verses,id',
            'user_id' => 'exists:users,id',
        ]);

        $khatmah->update($validatedData);
        return response()->json($khatmah);
    }
}
