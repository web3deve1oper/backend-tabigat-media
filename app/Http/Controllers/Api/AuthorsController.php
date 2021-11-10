<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\QueryBuilder;

class AuthorsController extends Controller
{
    public function index()
    {
        $perPage = request('itemsPerPage') ?? 100000;

        $authors = QueryBuilder::for(Author::class)
            ->allowedIncludes([
                AllowedInclude::relationship('articles')
            ])
            ->allowedSorts([
                'articles_count',
                'id',
                'updated_at',
                'created_at'
            ])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('biography'),
                AllowedFilter::partial('full_name'),
                AllowedFilter::scope('search', 'global_search')
            ])
            ->paginate($perPage);

        return $this->apiResponse($authors);
    }

    public function edit(Author $author)
    {
        return $this->apiResponse($author);
    }
}
