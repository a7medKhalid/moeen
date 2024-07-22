<?php

namespace App\Models\Monset\Traits;

use App\Models\Monset\AudioFile;
use App\Models\Monset\Clip;
use Illuminate\Database\Eloquent\Builder;

trait AudioFileHasData
{
    private static string $model = AudioFile::class;

    public static function getClipAvailableAudioFiles($clip): Builder {
        return static::$model::whereHas('segments', function (Builder $query) use ($clip) {
            $query
                ->where('type', 'verse')
                ->whereIn('type_id', Clip::getVersesIds($clip));
        });
    }

}
