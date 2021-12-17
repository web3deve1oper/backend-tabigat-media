<?php

namespace App\Http\Controllers\Admin;

use App\Exports\FeedbacksExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Feedback\DeleteFeedbackRequest;
use App\Models\Feedback;
use App\Models\Rubric;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class FeedbackController extends Controller
{
    public function delete(DeleteFeedbackRequest $request)
    {
        $feedbacks = $request->feedbacks;

        Feedback::destroy(array_column($feedbacks,'id'));

        return $this->apiResponse(null);
    }

    public function downloadFeedbacks()
    {
        return Excel::download(new FeedbacksExport, 'feedbacks.xlsx');
    }
}
