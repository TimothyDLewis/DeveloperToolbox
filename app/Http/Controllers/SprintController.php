<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Issue;
use App\Models\Sprint;
use App\Models\Project;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Traits\Controllers\Breadcrumbs;
use App\Http\Requests\Sprints\StoreSprintRequest;
use App\Http\Requests\Sprints\UpdateSprintRequest;

class SprintController extends Controller {
  use Breadcrumbs;

  public function index(): View {
    return view('sprints.index', $this->withBreadcrumbs(includes: ['sprints' => Sprint::withCount(['issues', 'occurrences'])->orderBy('id')->paginate(30)]));
  }

  public function create(): View {
    $estimateOptions = collect();
    $statusOptions = collect();

    if (old('project_id')) {
      $project = Project::with(['estimate.estimateOptions', 'status.statusOptions'])->find(old('project_id'));

      $estimateOptions = $project->estimate->estimateOptions;
      $statusOptions = $project->status->statusOptions;
    }

    return view('sprints.create', $this->withBreadcrumbs(
      path: 'create',
      includes: [
        'estimateOptions' => $estimateOptions,
        'issues' => Issue::orderBy('created_at', 'DESC')->get(),
        'projects' => Project::orderBy('id')->forSelect()->get(),
        'sprint' => new Sprint(),
        'statusOptions' => $statusOptions
      ]
    ));
  }

  public function store(StoreSprintRequest $request): RedirectResponse {
    try {
      DB::transaction(function () use ($request) {
        $sprint = Sprint::create(collect($request->validated())->except('issues')->toArray());

        if ($request->has('issues')) {
          $sprint->issues()->sync($request->validated()['issues']);
        }
      });

      $this->sessionSuccess('<strong>Sprint Created</strong>');

      return redirect()->route('sprints.index');
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Create Sprint</strong><br/><br/>Check logs for complete details.");

      return redirect()->back()->withInput();
    }
  }

  public function show(Sprint $sprint): View {
    $sprint->load(['issues'])->loadCount(['issues', 'occurrences']);

    return view('sprints.show', $this->withBreadcrumbs(
      path: 'show',
      additional: ['sprint' => $sprint],
      includes: ['sprint' => $sprint]
    ));
  }

  public function edit(Sprint $sprint): View {
    return view('sprints.edit', $this->withBreadcrumbs(
      path: 'edit',
      additional: ['sprint' => $sprint],
      includes: ['sprint' => $sprint]
    ));
  }

  public function update(UpdateSprintRequest $request, Sprint $sprint): RedirectResponse {
    try {
      $sprint->update($request->validated());
      $this->sessionSuccess('<strong>Sprint Updated</strong>');

      return redirect()->route('sprints.show', $sprint);
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Update Sprint</strong><br/><br/>Check logs for complete details.");

      return redirect()->back()->withInput();
    }
  }

  public function destroy(Sprint $sprint): RedirectResponse {
    try {
      $sprint->delete();

      $this->sessionSuccess('<strong>Sprint Deleted</strong>');

      return redirect()->route('sprints.index');
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Delete Sprint</strong><br/><br/>Check logs for complete details.");

      return redirect()->back();
    }
  }

  private function constructBreadcrumbs(string $path = null, array $additional = []): Collection {
    $breadcrumbs = collect([(object)['label' => 'Sprints', 'path' => route('sprints.index')]]);

    if ($path === 'create') {
      $breadcrumbs->push((object)['label' => 'Create Sprint', 'path' => route('sprints.create')]);
    } elseif ($path === 'show' || $path === 'edit') {
      $breadcrumbs->push((object)['label' => 'View Sprint', 'path' => route('sprints.show', $additional['sprint'])]);
      if ($path == 'edit') {
        $breadcrumbs->push((object)['label' => 'Edit Sprint', 'path' => route('sprints.edit', $additional['sprint'])]);
      }
    }

    $breadcrumbs->last()->active = true;

    return $breadcrumbs;
  }
}
