<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('docs', function () {
    $routeCollection = Route::getRoutes();

    $txt = "";

    foreach ($routeCollection->getRoutes() as $route) {
        $methods = implode('-', $route->methods);

        $txt .= "$methods | $route->uri |<br>";
    }

    return $txt;
});


Route::post('admin-login', [\App\Http\Controllers\AuthController::class, 'adminLogin']);

Route::get('/random-articles', [\App\Http\Controllers\Api\ArticlesController::class, 'getRandomArticles']);
Route::get('/daily-article', [\App\Http\Controllers\Api\ArticlesController::class, 'getDailyArticle']);
Route::group(['prefix' => 'articles'], function () {
    Route::get('', [\App\Http\Controllers\Api\ArticlesController::class, 'index']);
    Route::get('{article}', [\App\Http\Controllers\Api\ArticlesController::class, 'edit']);
    Route::get('{article}/recommended-articles',
        [\App\Http\Controllers\Api\ArticlesController::class, 'getRecommendedArticles']);

    Route::post('{article}/visited', [\App\Http\Controllers\Api\ArticlesController::class, 'visited']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('upload-temp-image', [\App\Http\Controllers\Admin\ArticleController::class, 'uploadTempImage']);
        Route::post('create', [\App\Http\Controllers\Admin\ArticleController::class, 'create']);
        Route::post('{article}/update', [\App\Http\Controllers\Admin\ArticleController::class, 'update']);
        Route::delete('{article}', [\App\Http\Controllers\Admin\ArticleController::class, 'delete']);
        Route::post('add-favourite/{article}', [\App\Http\Controllers\Admin\ArticleController::class, 'addFavourite']);
        Route::post('delete-favourite/{article}',
            [\App\Http\Controllers\Admin\ArticleController::class, 'deleteFavourite']);
        Route::post('add-daily/{article}', [\App\Http\Controllers\Admin\ArticleController::class, 'addDaily']);
        Route::post('delete-daily/{article}',
            [\App\Http\Controllers\Admin\ArticleController::class, 'deleteDaily']);
    });
});

Route::group(['prefix' => 'rubrics'], function () {
    Route::get('', [\App\Http\Controllers\Api\RubricsController::class, 'index']);

    Route::group(['middleware' => ['auth:sanctum', 'scopes:admin-actions']], function () {
        Route::post('edit-info', [\App\Http\Controllers\Admin\RubricsController::class, 'editInfo']);
        Route::post('upsert', [\App\Http\Controllers\Admin\RubricsController::class, 'upsert']);
        Route::delete('', [\App\Http\Controllers\Admin\RubricsController::class, 'delete']);
    });
});

Route::group(['prefix' => 'red-book'], function () {
    Route::get('', [\App\Http\Controllers\Api\RedBookController::class, 'index']);
    Route::get('{specie}', [\App\Http\Controllers\Api\RedBookController::class, 'edit']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('create', [\App\Http\Controllers\Admin\RedBookController::class, 'create']);
        Route::post('{specie}/update', [\App\Http\Controllers\Admin\RedBookController::class, 'update']);
        Route::delete('{specie}', [\App\Http\Controllers\Admin\RedBookController::class, 'delete']);
    });
});

Route::group(['prefix' => 'authors'], function () {
    Route::get('', [\App\Http\Controllers\Api\AuthorsController::class, 'index']);
    Route::get('{author}', [\App\Http\Controllers\Api\AuthorsController::class, 'edit']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('create', [\App\Http\Controllers\Admin\AuthorController::class, 'create']);
        Route::post('{author}/update', [\App\Http\Controllers\Admin\AuthorController::class, 'update']);
        Route::delete('{author}', [\App\Http\Controllers\Admin\AuthorController::class, 'delete']);
    });
});

Route::group(['prefix' => 'tags'], function () {
    Route::get('', [\App\Http\Controllers\Api\TagController::class, 'index']);
});

Route::group(['prefix' => 'feedbacks'], function () {
    Route::post('create', [\App\Http\Controllers\Api\FeedbackController::class, 'submitFeedback']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('', [\App\Http\Controllers\Api\FeedbackController::class, 'index']);
        Route::delete('', [\App\Http\Controllers\Admin\FeedbackController::class, 'delete']);
        Route::get('download', [\App\Http\Controllers\Admin\FeedbackController::class, 'downloadFeedbacks']);
    });
});

Route::group(['prefix' => 'mailings'], function () {
    Route::post('subscribe', [\App\Http\Controllers\Api\MailingController::class, 'subscribe']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('', [\App\Http\Controllers\Admin\MailingController::class, 'index']);
        Route::delete('', [\App\Http\Controllers\Admin\MailingController::class, 'delete']);
        Route::post('send', [\App\Http\Controllers\Admin\MailingController::class, 'sendMailing']);
    });
});

Route::group(['prefix' => 'audits'], function () {
    Route::get('', [\App\Http\Controllers\Admin\AuditController::class, 'index']);
    Route::get('{audit}', [\App\Http\Controllers\Admin\AuditController::class, 'edit']);
});

Route::group(['prefix' => 'users', 'middleware' => ['auth:sanctum', 'scopes:admin-actions']], function () {
    Route::get('', [\App\Http\Controllers\Api\UsersController::class, 'index']);
    Route::post('',
        [\App\Http\Controllers\AuthController::class, 'register'])->middleware('scopes:ultra-admin-actions');
    Route::get('{user}', [\App\Http\Controllers\Api\UsersController::class, 'edit']);
    Route::post('{user}',
        [\App\Http\Controllers\AuthController::class, 'update'])->middleware('scopes:ultra-admin-actions');
});

Route::group(['prefix' => 'page-settings'], function () {
    Route::get('', [\App\Http\Controllers\Api\PageSettingsController::class, 'index']);

    Route::group(['middleware' => ['auth:sanctum', 'scopes:admin-actions']], function () {
        Route::post('', [\App\Http\Controllers\Admin\PageSettingsController::class, 'store']);
    });
});
