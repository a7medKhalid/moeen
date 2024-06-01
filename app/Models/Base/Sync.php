<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sync extends Model
{
    use HasFactory;

    protected $casts = [
        'value' => 'json'
    ];
}
