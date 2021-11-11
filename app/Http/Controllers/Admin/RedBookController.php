<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RedBook\CreateRedBookRequest;
use App\Http\Requests\Admin\RedBook\UpdateRedBookRequest;
use App\Models\RedBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RedBookController extends Controller
{
    public function create(CreateRedBookRequest $request)
    {
        $specie = $request->all();

        if (isset($specie['preview_image_big'])) {
            $file = $request->file('preview_image_big');
            $image = Storage::disk('public')->put("/red-book-preview/", $file);
            $specie['preview_image_big_url'] = Storage::disk('public')->url($image);

            unset($specie['preview_image_big']);
        }

        if (isset($specie['preview_image_small'])) {
            $file = $request->file('preview_image_small');
            $image = Storage::disk('public')->put("/red-book-preview/", $file);
            $specie['preview_image_small_url'] = Storage::disk('public')->url($image);

            unset($specie['preview_image_small']);
        }

        $nSpecie = RedBook::create($specie);

        return $this->apiResponse($nSpecie);

    }

    public function update(UpdateRedBookRequest $request, RedBook $specie)
    {
        $updatedSpecie = $request->all();

        if (isset($updatedSpecie['preview_image_small'])) {
            $file = $request->file('preview_image_small');
            $image = Storage::disk('public')->put("/article_preview/", $file);
            $updatedSpecie['preview_image_small_url'] = Storage::disk('public')->url($image);
            unset($updatedSpecie['preview_image_small']);
        }

        if (isset($updatedSpecie['preview_image_big'])) {
            $file = $request->file('preview_image_big');
            $image = Storage::disk('public')->put("/article_preview/", $file);
            $updatedSpecie['preview_image_big_url'] = Storage::disk('public')->url($image);
            unset($updatedSpecie['preview_image_big']);
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
