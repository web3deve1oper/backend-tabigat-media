<?php

namespace App\Services\SpatieQueryBuilder\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class RubricArticlesCreatedAtSort implements Sort
{

    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $query->orderBy('articles.created_at', $descending ? 'DESC' : 'ASC');
    }
}
