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
                'rubric',
                'tags'
            ])
            ->allowedFilters([
//                    AllowedFilter::custom('search', new AlgoliaSearchFilter),
                AllowedFilter::scope('search', 'global_search'),
                AllowedFilter::exact('rubric.order', null),
                AllowedFilter::exact('author.id', null),
                AllowedFilter::exact('id'),
                AllowedFilter::exact('rubric.id'),
                AllowedFilter::callback('posted', function ($query, $value) {
                    $query->whereNotNull('posted_at');
                }),
                AllowedFilter::exact('tags.name', null),
                AllowedFilter::callback('favourite', function ($query, $value) {
                    $query->where('is_favourite', $value);
                }),
                AllowedFilter::callback('daily', function ($query, $value) {
                    $query->where('is_daily', $value);
                }),
                AllowedFilter::callback('id_not', function ($query, $value) {
                    $query->where('id', '!=', $value);
                })
            ])
            ->allowedSorts('id', 'views', 'read_time', 'created_at', 'posted_at', 'updated_at')
            ->paginate(request('itemsPerPage'));

        return $this->apiResponse($articles);
    }

    public function edit(Article $article)
    {
        return $this->apiResponse($article);
    }

    public function getRandomArticles()
    {
        $articles = QueryBuilder::for(Article::class)
            ->inRandomOrder()
            ->allowedSorts('id', 'views', 'read_time', 'created_at', 'posted_at', 'updated_at')
            ->allowedIncludes([
                AllowedInclude::relationship('rubric'),
                AllowedInclude::relationship('author')
            ])
            ->allowedFilters([
                AllowedFilter::callback('posted', function ($query, $value) {
                    $query->whereNotNull('posted_at');
                }),
                AllowedFilter::callback('id_not', function ($query, $value) {
                    $query->where('id', '!=', $value);
                })
            ])
            ->limit(request('itemsPerPage') ?? 8)
            ->get();

        return $this->apiResponse($articles);
    }

    public function getRecommendedArticles(Article $article)
    {
        $articles = QueryBuilder::for(Article::class)
            ->allowedFilters([
                AllowedFilter::exact('rubric.id'),
                AllowedFilter::callback('posted', function ($query, $value) {
                    $query->whereNotNull('posted_at');
                }),

                AllowedFilter::callback('id_not', function ($query, $value) {
                    $query->where('id', '!=', $value);
                })
            ])
            ->allowedIncludes([
                AllowedInclude::relationship('author'),
                AllowedInclude::relationship('rubric'),
            ])
            ->recommendedArticles()
            ->limit(\request('itemsPerPage') ?? 15)
            ->where('id', '!=', $article->id)
            ->get();


        return $this->apiResponse($articles);
    }
}
