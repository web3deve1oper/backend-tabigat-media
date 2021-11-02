<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class AuthorsController extends Controller
{
    public function index()
    {
        $perPage = request('itemsPerPage') ?? 100000;

        $authors = QueryBuilder::for(Author::class)
            ->paginate($perPage);

        return $this->apiResponse($authors);
    }
}
