<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Mailing\DeleteMailingsRequest;
use App\Http\Requests\Admin\Mailing\SendMailingRequest;
use App\Mail\Mailing\BasicMail;
use App\Models\Mailing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\QueryBuilder\QueryBuilder;

class MailingController extends Controller
{
    public function index()
    {
        $mailings = QueryBuilder::for(Mailing::class)
            ->allowedSorts([
                'id',
                'created_at'
            ])
            ->paginate(\request('itemsPerPage') ?? 15);

        return $this->apiResponse($mailings);
    }

    public function delete(DeleteMailingsRequest $request)
    {
        $mailings = $request->mailings;

        Mailing::destroy(array_column($mailings,'id'));

        return $this->apiResponse(null);
    }

    public function sendMailing(SendMailingRequest $request)
    {
        $data = $request->all();

        Mail::to(['eabilbay@gmail.com'])->send(new BasicMail($data['body'], $data['title'] ?? '', $data['article']), $data['subject']);
    }
}
