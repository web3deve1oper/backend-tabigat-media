<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Rubric extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

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
        'is_visible' => 'boolean',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',

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
