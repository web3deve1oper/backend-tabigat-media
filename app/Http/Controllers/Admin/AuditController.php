<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;
use Spatie\QueryBuilder\QueryBuilder;

class AuditController extends Controller
{
    public function index()
    {
        $audits = QueryBuilder::for(Audit::class)
            ->paginate(request('itemsPerPage'));

        return $this->apiResponse($audits);
    }

    public function edit(Audit $audit)
    {
        $audit['user'] = $audit->user;
        return $this->apiResponse($audit);
    }
}
