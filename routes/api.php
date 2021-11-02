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

Route::get('rubrics', [\App\Http\Controllers\Api\RubricsController::class, 'index']);
Route::get('authors', [\App\Http\Controllers\Api\AuthorsController::class, 'index']);

Route::group(['prefix' => 'articles'], function () {
    Route::get('', [\App\Http\Controllers\Api\ArticlesController::class, 'index']);
    Route::get('{article}/edit', [\App\Http\Controllers\Api\ArticlesController::class, 'edit']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('upload-temp-image', [\App\Http\Controllers\Admin\ArticleController::class, 'uploadTempImage']);
        Route::post('create', [\App\Http\Controllers\Admin\ArticleController::class, 'create']);
        Route::post('{article}/update', [\App\Http\Controllers\Admin\ArticleController::class, 'update']);
        Route::delete('', [\App\Http\Controllers\Admin\ArticleController::class, 'delete']);
    });
});

Route::group(['prefix' => 'rubrics', 'middleware' => ['auth:sanctum', 'scopes:admin-actions']], function () {
    Route::post('edit-info', [\App\Http\Controllers\Admin\RubricsController::class, 'editInfo']);
    Route::post('upsert', [\App\Http\Controllers\Admin\RubricsController::class, 'upsert']);
    Route::delete('', [\App\Http\Controllers\Admin\RubricsController::class, 'delete']);
});
