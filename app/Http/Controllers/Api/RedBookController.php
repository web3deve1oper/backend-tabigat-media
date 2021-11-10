<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RedBook;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class RedBookController extends Controller
{
    public function index()
    {
        $types = QueryBuilder::for(RedBook::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('name_latin'),
                AllowedFilter::partial('domain'),
                AllowedFilter::partial('type'),
                AllowedFilter::partial('squad'),
                AllowedFilter::partial('family'),
                AllowedFilter::partial('genus'),
                AllowedFilter::partial('kind'),
                AllowedFilter::scope('search','global_search'),
            ])
            ->paginate(\request('itemsPerPage') ?? 15);

        return $this->apiResponse($types);
    }

    public function edit(RedBook $specie)
    {
        return $this->apiResponse($specie);
    }
}
