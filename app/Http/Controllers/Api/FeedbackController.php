<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Feedback\SubmitFeedbackRequest;
use App\Mail\FeedbackSubmitted;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = QueryBuilder::for(Feedback::class)
            ->allowedSorts([
                'created_at',
                'updated_at',
                'id',
                'type'
            ])
            ->paginate(\request('itemsPerPage') ?? 15);

        return $this->apiResponse($feedbacks);
    }

    public function submitFeedback(SubmitFeedbackRequest $request)
    {
        $feedback = Feedback::create($request->all());

        Mail::to(env('ADMIN_EMAIL'))->send(new FeedbackSubmitted($request->all()));

        return $this->apiResponse($feedback);
    }

    public function delete(Feedback $feedback)
    {
        $feedback->delete();

        return $this->apiResponse(null);
    }
}
