<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EstimateController;
use App\Http\Controllers\ResourceController;

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
  Route::get('/estimates/{estimate}/estimate-options', [EstimateController::class, 'getEstimateOptions'])->name('estimates.estimate-options');

  Route::resource('projects', ProjectController::class);
  Route::get('/projects/{project}/select-options/{key?}', [ProjectController::class, 'getSelectOptions'])->name('projects.select-options');

  Route::resource('resources', ResourceController::class)->except('show');

  Route::resource('statuses', StatusController::class);
  Route::get('/statuses/{status}/status-options', [StatusController::class, 'getStatusOptions'])->name('statuses.status-options');

  Route::resource('issues', IssueController::class);
});
