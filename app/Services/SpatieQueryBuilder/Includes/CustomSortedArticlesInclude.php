<?php

namespace App\Services\SpatieQueryBuilder\Includes;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Includes\IncludeInterface;

class CustomSortedArticlesInclude implements IncludeInterface
{
    public function __invoke(Builder $query, string $include)
    {
        $query->with([
            'articles' => function ($q) {
                $q->orderBy('created_at','DESC')->che;
            }
        ]);
    }
}
