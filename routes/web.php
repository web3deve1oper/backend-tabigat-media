<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('',function() {
   return 'hello';
});

Route::group(['prefix' => 'admin'], function () {

    Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'login']);

    Route::get('/{any?}', function () {
        return view('welcome');
    });

    Route::group(['prefix' => 'rubrics', 'middleware' => ['auth:sanctum']], function () {
       Route::post('edit-info', [\App\Http\Controllers\Admin\RubricsController::class, 'editInfo']);
       Route::post('upsert', [\App\Http\Controllers\Admin\RubricsController::class, 'upsert']);
    });
});
