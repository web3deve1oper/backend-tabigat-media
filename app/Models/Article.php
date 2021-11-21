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
        'preview_image_big_url',
        'preview_image_small_url',
        'is_favourite',
        'is_daily'
    ];

    protected $with = [
        'tags'
    ];

    protected $casts = [
        'staff' => 'array',
        'posted_at' => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'is_long_read' => 'boolean',
        'is_favourite' => 'boolean'
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
            ->orWhereHas('author', function ($q) use ($search) {
                $q->where('full_name', 'LIKE', "%$search%");
            })
            ->orWhereHas('rubric', function ($q) use ($search) {
                $q->where('title', 'LIKE', "%$search%");
            })
            ->orWhereHas('tags', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%");
            });
    }

    protected function makeAllSearchableUsing($query)
    {
        return $query->with('author', 'rubric');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopeRecommendedArticles(Builder $query)
    {
        $query->whereHas('tags', function ($q) {
            $relatedTags = $this->tags()->get();
            foreach ($relatedTags as $tag) {
                $q->orWhere('name', $tag->name);
            }
        });
    }
}
