<?php

namespace App\Services\SpatieQueryBuilder\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class AlgoliaSearchFilter implements Filter
{

    public function __invoke(Builder $query, $value, string $property)
    {
        $ids = $query->getModel()::search($value)
            ->get()
            ->pluck('id');

        $query->whereIn('id', $ids);
    }
}
