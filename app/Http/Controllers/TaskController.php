<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Task;
use App\Models\Issue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Tasks\StoreTaskRequest;
use App\Http\Requests\Tasks\UpdateTaskRequest;

class TaskController extends Controller {
  public function index(): View {
    return view('tasks.index', $this->withBreadcrumbs(includes: ['tasks' => Task::orderBy('id', 'DESC')->paginate(30)]));
  }

  public function create(): View {
    return view('tasks.create', $this->withBreadcrumbs(
      path: 'create',
      includes: [
        'issues' => Issue::orderBy('id')->forSelect("CONCAT(code, ' - ', title)", raw: true)->orderBy('code')->orderBy('title')->get(),
        'task' => new Task()
      ]
    ));
  }

  public function store(StoreTaskRequest $request): RedirectResponse {
    try {
      Task::create($request->validated());

      $this->sessionSuccess('<strong>Task Created</strong>');

      return redirect()->route('tasks.index');
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Create Task</strong><br/><br/>Check logs for complete details.");

      return redirect()->back()->withInput();
    }
  }

  public function show(Task $task): View {
    return view('tasks.show', $this->withBreadcrumbs(
      path: 'show',
      additional: ['task' => $task],
      includes: ['task' => $task]
    ));
  }

  public function edit(Task $task): View {
    if ($task->start_datetime && $task->all_day) {
      $task->start_datetime = substr($task->start_datetime, 0, 10);
    }

    return view('tasks.edit', $this->withBreadcrumbs(
      path: 'edit',
      additional: ['task' => $task],
      includes: [
        'issues' => Issue::orderBy('id')->forSelect("CONCAT(code, ' - ', title)", raw: true)->orderBy('code')->orderBy('title')->get(),
        'task' => $task
      ]
    ));
  }

  public function update(UpdateTaskRequest $request, Task $task): RedirectResponse {
    try {
      $task->update($request->validated());
      $this->sessionSuccess('<strong>Task Updated</strong>');

      return redirect()->route('tasks.show', $task);
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Update Task</strong><br/><br/>Check logs for complete details.");

      return redirect()->back()->withInput();
    }
  }

  public function destroy(Task $task): RedirectResponse {
    try {
      $task->delete();

      $this->sessionSuccess('<strong>Task Deleted</strong>');

      return redirect()->route('tasks.index');
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Delete Task</strong><br/><br/>Check logs for complete details.");

      return redirect()->back();
    }
  }

  protected function constructBreadcrumbs(string $path = null, array $additional = []): Collection {
    $breadcrumbs = collect([(object)['label' => 'Tasks', 'path' => route('tasks.index')]]);

    if ($path === 'create') {
      $breadcrumbs->push((object)['label' => 'Create Task', 'path' => route('tasks.create')]);
    } elseif ($path === 'show' || $path === 'edit') {
      $breadcrumbs->push((object)['label' => 'View Task', 'path' => route('tasks.show', $additional['task'])]);
      if ($path == 'edit') {
        $breadcrumbs->push((object)['label' => 'Edit Task', 'path' => route('tasks.edit', $additional['task'])]);
      }
    }

    $breadcrumbs->last()->active = true;

    return $breadcrumbs;
  }
}
