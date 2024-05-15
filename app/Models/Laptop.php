<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'serial_number',
        'brand',
        'warrantyexpirationdate',
        'fullbatterycapacity',
        'currentbatterycapacity',
        'diskperformance',
        'fullbatterycapacitydate',
        'currentbatterycapacitydate',
        'diskperformancedate',
        'spec',
        'status',
        'picture'
    ];
}
