<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verse extends Model
{
    use HasFactory;

    protected function orderedId(): Attribute{
        return Attribute::get(fn() => $this->surah_id . ':' . $this->order);
    }
}
