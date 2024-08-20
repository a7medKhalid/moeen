<?php

namespace App\Http\Controllers\Monset;

use App\Http\Controllers\Controller;
use App\Models\Core\Verse;
use App\Models\Monset\Clip;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(){

        $stringVersesKeys = request()->get('verses-keys');
        $search = request()->get('search');

        $VersesKeys = explode(',', $stringVersesKeys);

        $searchClips = Clip::whereHas('phrases', function ($query) use ($search){
            $query->where('value', 'like', "%$search%");
        })->get();

        if (is_null($stringVersesKeys)) {
            return response()->json($searchClips);
        }
        $versesClips = collect();
        foreach ($VersesKeys as $verse){
            $verse = explode(':', $verse);
            $surah = (int)$verse[0];
            $verse = (int)$verse[1];
            $verses = Verse::where('surah_id', $surah)->where('order', $verse)->first();
            $verseClips = $verses?->clips()->get();
            $versesClips = $versesClips->merge($verseClips);
        }
        return response()->json($searchClips->merge($versesClips));
    }
}
