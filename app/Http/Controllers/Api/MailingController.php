<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Mailing\MailingSubscribeRequest;
use App\Models\Mailing;
use Illuminate\Http\Request;

class MailingController extends Controller
{
    public function subscribe(MailingSubscribeRequest $request)
    {
        $email = $request->all()['email'];

        Mailing::create([
            'email' => $email
        ]);

        return $this->apiResponse(null);
    }
}
