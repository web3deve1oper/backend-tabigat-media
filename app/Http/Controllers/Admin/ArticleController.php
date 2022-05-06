<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Article\CreateArticleRequest;
use App\Http\Requests\Admin\Article\DeleteArticlesRequest;
use App\Http\Requests\Admin\Article\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function uploadTempImage(Request $request)
    {
        $file = $request->upload;
        $image = Storage::disk('public')->put("/images/", $file);

        return response()->json([
            'url' => Storage::disk('public')->url($image),
            'uploaded' => 1,
            'filename' => $file->getClientOriginalName()
        ]);
    }


    public function create(CreateArticleRequest $request)
    {
        $article = $request->all();

        $tags = Tag::createOrReturnIds($article['tags'] ?? []);

        if (isset($article['preview_image_big'])) {
            $file = $request->file('preview_image_big');
            $fileName = $file->getClientOriginalName();
            $image = Storage::disk('public')->put("/article_preview/", $fileName);
            $article['preview_image_big_url'] = Storage::disk('public')->url($image);

            unset($article['preview_image_big']);
        }

        if (isset($article['preview_image_small'])) {
            $file = $request->file('preview_image_small');
            $fileName = $file->getClientOriginalName();
            $image = Storage::disk('public')->put("/article_preview/", $fileName);
            $article['preview_image_small_url'] = Storage::disk('public')->url($image);

            unset($article['preview_small_big']);
        }

        $article = Article::create([
                'title' => $article['title'],
                'rubric_id' => $article['rubric_id'],
                'description' => $article['description'],
                'content' => $article['content'],
                'author_id' => $article['author'],
                'is_long_read' => $article['is_long_read'] === 'true',
                'posted_at' => $article['posted'] ? now() : null,
                'read_time' => $article['read_time'],
                'photography' => $article['photography'],
                'staff' => $article['staff'] ?? [],
                'slug' => $article['slug'],
                'preview_image_big_url' => $article['preview_image_big_url'] ?? '',
                'preview_image_small_url' => $article['preview_image_small_url']
            ]
        );

        $article->tags()->sync($tags);

        return $this->apiResponse($article);
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
        $art = $request->all();

        $tags = Tag::createOrReturnIds($art['tags'] ?? []);

        if (isset($art['preview_image_big'])) {
            $file = $request->file('preview_image_big');
            $fileName = $file->getClientOriginalName();
            $image = Storage::disk('public')->put("/article_preview/", $fileName);
            $article['preview_image_big_url'] = Storage::disk('public')->url($image);

            unset($art['preview_image_big']);
        }

        if (isset($art['preview_image_small'])) {
            $file = $request->file('preview_image_small');
            $fileName = $file->getClientOriginalName();
            $image = Storage::disk('public')->put("/article_preview/", $fileName);
            $article['preview_image_small_url'] = Storage::disk('public')->url($image);

            unset($art['preview_image_small']);
        }

        $article->title = $art['title'];
        $article->slug = $art['slug'];
        $article->description = $art['description'];
        $article->author_id = $art['author_id'] ?? null;
        $article->rubric_id = $art['rubric_id'] ?? null;
        $article->content = $art['content'] ?? null;
        $article->is_long_read = $art['is_long_read'] === 'true';
        $article->posted_at = $art['posted'] === 'true' ? now()->toDateTimeString() : null;
        $article->read_time = $art['read_time'] ?? null;
        $article->photography = $art['photography'] ?? null;
        $article->staff = $art['staff'] ?? null;
        $article->save();

        $article->tags()->sync($tags);

        return $this->apiResponse($article);
    }

    public function delete(Article $article)
    {
        $article->delete();

        return $this->apiResponse(null);
    }

    public function addFavourite(Article $article)
    {
        $article->is_favourite = true;
        $article->save();

        return $this->apiResponse($article);
    }

    public function deleteFavourite(Article $article)
    {
        $article->is_favourite = false;
        $article->save();

        return $this->apiResponse(null);
    }

    public function addDaily(Article $article)
    {
        $article->is_daily = true;
        $article->save();

        $article['author'] = $article->author;

        return $this->apiResponse($article);
    }

    public function deleteDaily(Article $article)
    {
        $article->is_daily = false;
        $article->save();

        return $this->apiResponse(null);
    }
}
