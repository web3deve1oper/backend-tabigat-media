<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rubric extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'is_red_book',
        'order',
        'is_preferable',
        'is_visible'
    ];

    protected $casts = [
        'is_red_book' => 'boolean',
        'is_preferable' => 'boolean',
        'is_visible' => 'boolean'
    ];
}
