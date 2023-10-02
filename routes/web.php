<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EstimateController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\SchedulerController;
use App\Http\Controllers\OccurrenceController;

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

Route::get('/config', function ($key = null) {
  if (app()->isProduction()) {
    abort(404);
  }

  $config = [];
  foreach(Storage::disk('config')->files() as $file) {
    $key = explode('.', $file)[0];
    $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator(config($key)));

    $result = array();
    foreach ($iterator as $value) {
      $keys = array();
      foreach (range(0, $iterator->getDepth()) as $depth) {
        $keys[] = $iterator->getSubIterator($depth)->key();
      }

      $result[$key . '.' . implode('.', $keys)] = $value;
    }

    $config[$key] = $result;
  }

  return view('system.config', ['config' => $config]);
});

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
  })->name('organization');

  Route::get('/estimates/{estimate}/estimate-options', [EstimateController::class, 'getEstimateOptions'])->name('estimates.estimate-options');
  Route::resource('estimates', EstimateController::class);

  Route::resource('event-types', EventTypeController::class);
  Route::resource('events', EventController::class);

  Route::resource('issues', IssueController::class);
  Route::patch('/issues/{issue}/move/{direction}', [IssueController::class, 'move'])->name('issues.move');

  Route::resource('occurrences', OccurrenceController::class);

  Route::resource('projects', ProjectController::class);
  Route::get('/projects/{project}/select-options/{key?}', [ProjectController::class, 'getSelectOptions'])->name('projects.select-options');

  Route::resource('resources', ResourceController::class)->except('show');

  Route::resource('statuses', StatusController::class);
  Route::get('/statuses/{status}/status-options', [StatusController::class, 'getStatusOptions'])->name('statuses.status-options');

  Route::resource('sprints', SprintController::class);
  Route::post('/sprints/{sprint}/regenerate', [SprintController::class, 'regenerate'])->name('sprints.regenerate');

  Route::resource('tasks', TaskController::class);
  Route::patch('/tasks/{task}/log', [TaskController::class, 'log'])->name('tasks.log');
});

Route::group(['prefix' => 'scheduler'], function () {
  Route::get('/', [SchedulerController::class, 'index'])->name('scheduler');
  Route::post('/events', [SchedulerController::class, 'events'])->name('scheduler.events');
  Route::get('/sprints/{sprint}', [SchedulerController::class, 'sprint'])->name('scheduler.sprint');
});
