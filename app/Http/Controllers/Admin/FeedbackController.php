<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Feedback\DeleteFeedbackRequest;
use App\Models\Feedback;
use App\Models\Rubric;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function delete(DeleteFeedbackRequest $request)
    {
        $feedbacks = $request->feedbacks;

        Feedback::destroy(array_column($feedbacks,'id'));

        return $this->apiResponse(null);
    }


}
