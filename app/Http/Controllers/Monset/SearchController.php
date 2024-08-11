<?php

namespace App\Http\Controllers\Monset;

use App\Http\Controllers\Controller;
use App\Models\Core\Verse;
use App\Models\Monset\Clip;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(){
//        $versesIds = request()->get('versesIds');
//        $search = request()->get('search');
        $stringVersesIds = ['1:2', '2:3', '3:4'];
        $search = 'الفاتحة';

        $searchClips = Clip::whereHas('phrases', function ($query) use ($search){
            $query->where('value', 'like', "%$search%");
        })->get();
        $versesClips = [];
        foreach ($stringVersesIds as $verse){
            $verse = explode(':', $verse);
            $chapter = $verse[0];
            $verse = $verse[1];
            $verses = Verse::where('chapter', $chapter)->where('verse', $verse)->first();
            $verseClips = $verses->clips;
            $versesClips = array_merge($versesClips, $verseClips->toArray());
        }
        return response()->json(array_merge($searchClips->toArray(), $versesClips));
    }
}
