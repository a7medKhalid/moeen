<?php

namespace App\Models\Monset;

use App\Enums\Monset\Segment\type;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Segment extends Model
{
    use HasFactory;

    protected $casts = [
        'type' => type::class
    ];
}
