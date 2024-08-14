<?php

namespace App\Models\Monset;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reciter extends Model
{
    use HasFactory;

    protected function name(): Attribute{
        return Attribute::get(fn(string $value) => __('reciters.' . $value));
    }
}
