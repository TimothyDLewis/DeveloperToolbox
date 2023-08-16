<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EstimateController;
use App\Http\Controllers\StatusController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/info', function () {
  if (app()->isProduction()) {
    abort(404);
  }

  phpinfo();
});

Route::get('/test', function () {
  if (app()->isProduction()) {
    abort(404);
  }

  // Test away! "With great power, something, something, dark side." - Unknown
  abort(404);
});

// -TODO- Convert to Controller and load Content
Route::get('/', function () {
  return view('dashboard');
});

Route::group(['prefix' => 'organization'], function () {
  Route::get('/', function () {
    return redirect()->route('projects.index');
  });

  Route::resource('estimates', EstimateController::class);
  Route::resource('projects', ProjectController::class);
  Route::resource('statuses', StatusController::class);
});
