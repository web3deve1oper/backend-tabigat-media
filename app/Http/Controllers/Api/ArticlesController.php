<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Article\CreateArticleRequest;
use App\Models\Article;
use App\Services\SpatieQueryBuilder\Filters\AlgoliaSearchFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\QueryBuilder;

class ArticlesController extends Controller
{
    public function index()
    {
            $articles = QueryBuilder::for(Article::class)
                ->defaultSort('id')
                ->allowedIncludes([
                    'author',
                    'rubric'
                ])
                ->allowedFilters([
//                    AllowedFilter::custom('search', new AlgoliaSearchFilter),
                    AllowedFilter::scope('search','global_search'),
                    AllowedFilter::exact('rubric.order',null)
                ])
                ->allowedSorts('id', 'views', 'read_time', 'created_at', 'posted_at', 'updated_at')
                ->paginate(request('itemsPerPage'));

            return $this->apiResponse($articles);
    }

    public function edit(Article $article)
    {
        return $this->apiResponse($article);
    }
}
