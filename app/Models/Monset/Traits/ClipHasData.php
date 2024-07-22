<?php

namespace App\Models\Monset\Traits;

use App\Models\Monset\Clip;
use Illuminate\Database\Eloquent\Builder;

trait ClipHasData
{
    private static string $model = Clip::class;

    public static function getVersesIds($model): array {
        $verses = $model->verses->select('start_verse_id', 'end_verse_id');
        $ids = [];
        foreach ($verses as $verse) {
            $ids = array_merge($ids, range($verse['start_verse_id'], $verse['end_verse_id']));
        }
        return $ids;
    }

}
