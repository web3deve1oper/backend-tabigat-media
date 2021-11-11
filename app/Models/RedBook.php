<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedBook extends Model
{
    use HasFactory;

    protected $table = 'red_book';

    protected $fillable = [
        'name',
        'name_latin',
        'kingdom',
        'type',
        'class',
        'squad',
        'family',
        'genus',
        'kind',
        'subkind',
        'content',
        'status',
        'facts',
        'preview_image_big_url',
        'preview_image_small_url',
        'slug',
        'description'
    ];

    protected $casts = [
        'status' => 'array',
        'facts' => 'array'
    ];

    public function scopeGlobalSearch(Builder $query, $search)
    {
        return $query->where('id', $search)
            ->orWhere('content', 'LIKE', "%$search$%")
            ->orWhere('name', 'LIKE', "%$search%")
            ->orWhere('name_latin', 'LIKE', "%$search%")
            ->orWhere('kingdom', 'LIKE', "%$search%")
            ->orWhere('type', 'LIKE', "%$search%")
            ->orWhere('class', 'LIKE', "%$search%")
            ->orWhere('family', 'LIKE', "%$search%")
            ->orWhere('genus', 'LIKE', "%$search%")
            ->orWhere('kind', 'LIKE', "%$search%")
            ->orWhere('subkind', 'LIKE', "%$search%")
            ->orWhere('squad', 'LIKE', "%$search%");
    }
}
