<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rubric;
use App\Services\SpatieQueryBuilder\Includes\CustomSortedArticlesInclude;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class RubricsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $rubrics = QueryBuilder::for(Rubric::class)
            ->defaultSort('id', 'created_at')
            ->allowedSorts([
                'id',
                'title',
                'order',
                'articles_count'
            ])
            ->allowedIncludes([
                'articles'
                //AllowedInclude::custom('selfSortedArticles', new CustomSortedArticlesInclude())
            ])
            ->allowedFilters([
                AllowedFilter::exact('order'),
                AllowedFilter::exact('id'),
                AllowedFilter::callback('preferable', function ($q) {
                    $q->where('is_preferable', true);
                }),
                AllowedFilter::callback('visible', function ($q) {
                    $q->where('is_visible', true);
                })
            ])
            ->paginate(request('itemsPerPage'));

        return $this->apiResponse($rubrics);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
