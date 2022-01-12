<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UsersController extends Controller
{
    public function index()
    {
        $users = QueryBuilder::for(User::class)
            ->defaultSort('id', 'created_at')
            ->allowedSorts([
                'id',
                'name',
                'created_at'
            ])
            ->paginate(request('itemsPerPage'));

        return $this->apiResponse($users);
    }

    public function edit(User $user)
    {
        return $this->apiResponse($user);
    }
}
