<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Author\CreateAuthorRequest;
use App\Http\Requests\Admin\Author\UpdateAuthorRequest;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    public function create(CreateAuthorRequest $request)
    {
        $author = $request->all();

        if (isset($author['preview_image'])) {
            $file = $request->file('preview_image');
            $fileName = $file->getClientOriginalName();
            $image = Storage::disk('public')->put("/article_preview/", $fileName);
            $author['preview_image_url'] = Storage::disk('public')->url($image);

            unset($author['preview_image']);
        }

        $author = Author::create($author);

        return $this->apiResponse($author);
    }

    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $updatedAuthor = $request->all();

        if (isset($updatedAuthor['preview_image'])) {
            $file = $request->file('preview_image');
            $fileName = $file->getClientOriginalName();
            $image = Storage::disk('public')->put("/article_preview/", $fileName);
            $updatedAuthor['preview_image_url'] = Storage::disk('public')->url($image);

            unset($updatedAuthor['preview_image']);
        }

        foreach ($updatedAuthor as $col => $value) {
            $author->$col = $value;
        }

        $author->save();

        return $this->apiResponse($author);
    }

    public function delete(Author $author)
    {
        $author->delete();

        return $this->apiResponse(null);
    }
}
