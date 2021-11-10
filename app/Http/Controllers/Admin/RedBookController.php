<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateRedbookSpecieRequest;
use App\Http\Requests\Admin\RedBook\UpdateRedBookRequest;
use App\Models\RedBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RedBookController extends Controller
{
    public function create(CreateRedbookSpecieRequest $request)
    {
        $specie = $request->all();

        if (isset($specie['preview_image'])) {
            $file = $request->file('preview_image');
            $image = Storage::disk('public')->put("/red-book-preview/", $file);
            $specie['preview_image_url'] = Storage::disk('public')->url($image);

            unset($specie['preview_image']);
        }

        $nSpecie = RedBook::create($specie);

        return $this->apiResponse($nSpecie);

    }

    public function update(UpdateRedBookRequest $request, RedBook $specie)
    {
        $updatedSpecie = $request->all();

        if (isset($updatedSpecie['preview_image'])) {
            $file = $request->file('preview_image');
            $image = Storage::disk('public')->put("/article_preview/", $file);
            $updatedSpecie['preview_image_url'] = Storage::disk('public')->url($image);
            unset($updatedSpecie['preview_image']);
        }

        foreach ($updatedSpecie as $col=>$value) {
            $specie[$col] = $value;
        }

        $specie->save();

        return $this->apiResponse($specie);
    }

    public function delete(RedBook $specie)
    {
       $specie->delete();

       return $this->apiResponse(null);
    }
}
