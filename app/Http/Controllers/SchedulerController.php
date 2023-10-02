<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\Issue;
use App\Models\Sprint;
use App\Models\EventType;
use App\Models\Occurrence;
use App\Traits\SessionFlash;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SchedulerController extends Controller {
  use SessionFlash;

  public array | Collection $jsPaths = [];

  public function __construct() {
    $task = ['task' => ':task'];
    $occurrence = ['occurrence' => ':occurrence'];

    $this->jsPaths = collect([
      'issues.move' => route('issues.move', ['issue' => ':issue', 'direction' => ':direction']),
      'occurrences.destroy' => route('occurrences.destroy', $occurrence),
      'occurrences.store' => route('occurrences.store'),
      'occurrences.update' => route('occurrences.update', $occurrence),
      'scheduler.events' => route('scheduler.events'),
      'sprints.show' => route('sprints.show', ['sprint' => ':sprint']),
      'tasks.destroy' => route('tasks.destroy', $task),
      'tasks.log' => route('tasks.log', $task),
      'tasks.store' => route('tasks.store'),
      'tasks.update' => route('tasks.update', $task)
    ]);
  }

  public function index(): View {
    $currentSprint = Sprint::overlapsDate(Carbon::today())->first();

    return view('scheduler', $this->withBreadcrumbs(includes: [
      'eventTypes' => EventType::withWhereHas('events', function ($subQuery) {
        return $subQuery->orderBy('title');
      })->withCount(['events'])->orderBy('title')->get(),
      'jsPaths' => $this->jsPaths,
      'sprint' => $currentSprint,
      'issues' => Issue::orderBy('code')->get()
    ]));
  }

  public function events(Request $request): JsonResponse {
    $request->validate([
      'start' => ['required', 'date', 'before_or_equal:end'],
      'end' => ['required', 'date', 'after_or_equal:start']
    ]);

    $dateRange = [Carbon::parse($request->input('start')), Carbon::parse($request->input('end'))];

    $occurrences = Occurrence::with('event.eventType')->whereBetween('start_datetime', $dateRange)->get()->map(function (Occurrence $occurrence) {
      return $occurrence->present('forScheduler');
    });

    $tasks = Task::with(['issue.estimateOption', 'issue.project', 'issue.statusOption.previousStatusOption', 'issue.statusOption.nextStatusOption'])->whereBetween('start_datetime', $dateRange)->get()->map(function (Task $task) {
      return $task->present('forScheduler');
    });

    return response()->json(array_merge($occurrences->toArray(), $tasks->toArray()), 200);
  }

  public function sprint(int $sprintId): RedirectResponse | View {
    try {
      $sprint = Sprint::findOrFail($sprintId);
      $sprint->restrictDates = true;

      return view('scheduler', $this->withBreadcrumbs(
        path: 'sprint',
        additional: ['sprint' => $sprint],
        includes: [
          'eventTypes' => EventType::withWhereHas('events', function ($subQuery) {
            return $subQuery->orderBy('title');
          })->withCount(['events'])->orderBy('title')->get(),
          'jsPaths' => $this->jsPaths,
          'sprint' => $sprint,
          'issues' => !$sprint->issues->isEmpty() ? $sprint->issues : Issue::orderBy('code')->get()
        ]
      ));
    } catch (ModelNotFoundException $_mnfex) {
      $this->sessionDanger('<strong>Unable to Find Sprint</strong><br/><br/>Redirected to Scheduler.');

      return redirect()->route('scheduler');
    }
  }

  protected function constructBreadcrumbs(string $path = null, array $additional = []): Collection {
    $breadcrumbs =  collect([(object)['label' => 'Scheduler', 'path' => route('scheduler')]]);

    if ($path === 'sprint') {
      $sprint = $additional['sprint'];

      $breadcrumbs->push((object)['label' => 'Sprints', 'path' => route('sprints.index')]);
      $breadcrumbs->push((object)['label' => $sprint->title, 'path' => route('scheduler.sprint', $sprint)]);
    }

    $breadcrumbs->last()->active = true;

    return $breadcrumbs;
  }
}
