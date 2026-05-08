<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'purok',
        'status',
    ];

    protected $casts = [
        'age' => 'integer',
    ];
}
