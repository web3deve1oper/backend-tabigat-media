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
        'is_visible',
        'type',
        'description',
        'slug'
    ];

    protected $casts = [
        'is_red_book' => 'boolean',
        'is_preferable' => 'boolean',
        'is_visible' => 'boolean'
    ];

    const TYPES = [
        'default-view',
        'fluid-view',
        'red-book',
        'solo-view',
        'staggered-view'
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
