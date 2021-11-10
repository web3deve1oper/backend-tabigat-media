<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Article\CreateArticleRequest;
use App\Http\Requests\Admin\Article\DeleteArticlesRequest;
use App\Http\Requests\Admin\Article\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function uploadTempImage(Request $request)
    {
        $file = $request->file;
        $image = Storage::disk('public')->put("/images/", $file);

        return $this->apiResponse(['url' => Storage::disk('public')->url($image)]);
    }


    public function create(CreateArticleRequest $request)
    {
        $article = $request->all();

        $tags = Tag::createOrReturnIds($article['tags'] ?? []);

        if (isset($article['preview_image'])) {
            $file = $request->file('preview_image');
            $image = Storage::disk('public')->put("/article_preview/", $file);
            $article['preview_image_url'] = Storage::disk('public')->url($image);

            unset($article['preview_image']);
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
                'preview_image_url' => $article['preview_image_url']
            ]
        );

        $article->tags()->sync($tags);

        return $this->apiResponse($article);
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
        $art = $request->all();

        $tags = Tag::createOrReturnIds($art['tags'] ?? []);

        if (isset($art['preview_image'])) {
            $file = $request->file('preview_image');
            $image = Storage::disk('public')->put("/article_preview/", $file);
            $article['preview_image_url'] = Storage::disk('public')->url($image);

            unset($art['preview_image']);
        }

        $article->title = $art['title'];
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
}
