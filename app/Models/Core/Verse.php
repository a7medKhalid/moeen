<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verse extends Model
{
    use HasFactory {

    }

    protected function orderId(): Attribute {
        return Attribute::get(fn(Model $record) => $record->surah_id . ':' . $record->order);
    }
}
