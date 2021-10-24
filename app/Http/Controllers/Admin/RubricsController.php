<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Rubric\EditRubricInfoRequest;
use App\Http\Requests\Admin\Rubric\UpsertRubricRequest;
use App\Models\Rubric;
use Illuminate\Http\Request;

class RubricsController extends Controller
{
    public function editInfo(EditRubricInfoRequest $request)
    {
        $rubrics = $request->rubrics;

        foreach ($rubrics as $rubric) {
            Rubric::where('id', $rubric['id'])
                ->update([
                    'order' => $rubric['order'],
                    'is_visible' => $rubric['is_visible'],
                    'is_preferable' => $rubric['is_preferable']
                ]);
        }

        return $this->apiResponse(null);
    }

    public function upsert(UpsertRubricRequest $request)
    {
        $rubric = $request->rubric;

        $rubric = Rubric::updateOrCreate(
            ['title' => $rubric['title'], 'id' => $rubric['id'] ?? 0],
            $rubric
        );

        return $this->apiResponse($rubric);
    }
}
