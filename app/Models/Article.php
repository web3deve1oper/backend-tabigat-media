<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Article extends Model
{
//    use Searchable;
    use HasFactory;

    protected $fillable = [
        'author_id',
        'rubric_id',
        'title',
        'slug',
        'description',
        'content',
        'is_long_read',
        'posted_at',
        'read_time',
        'photography',
        'views',
        'staff',
        'preview_image_url'
    ];

    protected $casts = [
        'staff' => 'array',
        'posted_at' => 'date:Y-m-d',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'is_long_read' => 'boolean'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function rubric()
    {
        return $this->belongsTo(Rubric::class);
    }

    public function scopeGlobalSearch(Builder $query, $search)
    {
        return $query->where('id', $search)
            ->orWhere('content', 'LIKE', "%$search$%")
            ->orWhere('title', 'LIKE', "%$search%")
            ->orWhere('description', 'LIKE', "%$search%")
            ->orWhereHas('author',function ($q) use ($search) {
                $q->where('full_name', 'LIKE', "%$search%");
            })
            ->orWhereHas('rubric', function ($q) use ($search) {
                $q->where('title','LIKE', "%$search%");
            });
    }

    protected function makeAllSearchableUsing($query)
    {
        return $query->with('author', 'rubric');
    }
}
