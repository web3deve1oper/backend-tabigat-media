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

Route::get('docs', function() {
   $routeCollection = Route::getRoutes();

   $txt = "";

   foreach ($routeCollection->getRoutes() as $route) {
       $methods = implode('-', $route->methods);

       $txt .= "$methods | $route->uri |<br>";
   }

   return $txt;
});

Route::resource('rubrics', \App\Http\Controllers\Api\RubricsController::class);
