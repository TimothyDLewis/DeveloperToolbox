<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Status;
use App\Models\Project;
use App\Models\Estimate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Projects\StoreProjectRequest;
use App\Http\Requests\Projects\UpdateProjectRequest;

class ProjectController extends Controller {
  public function index(): View {
    return view('projects.index', $this->withBreadcrumbs(includes: ['projects' => Project::with(['estimate', 'status'])->withCount(['issues', 'resources'])->orderBy('touched_at', 'DESC')->orderBy('title')->paginate(30)]));
  }

  public function create(): View {
    return view('projects.create', $this->withBreadcrumbs(
      path: 'create',
      includes: [
        'estimates' => Estimate::orderBy('id')->forSelect()->get(),
        'project' => new Project(),
        'statuses' => Status::orderBy('id')->forSelect()->get()
      ]
    ));
  }

  public function store(StoreProjectRequest $request): RedirectResponse {
    try {
      Project::create($request->validated());

      $this->sessionSuccess('<strong>Project Created</strong>');

      return redirect()->route('projects.index');
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Create Project</strong><br/><br/>Check logs for complete details.");

      return redirect()->back()->withInput();
    }
  }

  public function show(Project $project): View {
    $project->load(['estimate', 'status'])->loadCount(['issues', 'resources']);
    $this->touchModel($project);

    return view('projects.show', $this->withBreadcrumbs(
      path: 'show',
      additional: ['project' => $project],
      includes: ['project' => $project]
    ));
  }

  public function edit(Project $project): View {
    $this->touchModel($project);

    return view('projects.edit', $this->withBreadcrumbs(
      path: 'edit',
      additional: ['project' => $project],
      includes: [
        'estimates' => Estimate::orderBy('id')->forSelect()->get(),
        'project' => $project,
        'statuses' => Status::orderBy('id')->forSelect()->get()
      ]
    ));
  }

  public function update(UpdateProjectRequest $request, Project $project): RedirectResponse {
    try {
      $project->update($request->validated());
      $this->sessionSuccess('<strong>Project Updated</strong>');

      return redirect()->route('projects.show', $project);
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Update Project</strong><br/><br/>Check logs for complete details.");

      return redirect()->back()->withInput();
    }
  }

  public function destroy(Project $project): RedirectResponse {
    try {
      $project->delete();

      $this->sessionSuccess('<strong>Project Deleted</strong>');

      return redirect()->route('projects.index');
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Delete Project</strong><br/><br/>Check logs for complete details.");

      return redirect()->back();
    }
  }

  // Additional Non-Resource Routes

  public function getSelectOptions(Project $project, ?string $key = null) {
    $project->load(['estimate' => function ($query) {
      return $query->with(['estimateOptions' => function ($subQuery) {
        return $subQuery->forSelect('label', 'estimate_id');
      }])->forSelect();
    }, 'status' => function ($query) {
      return $query->with(['statusOptions' => function ($subQuery) {
        return $subQuery->forSelect('label', 'status_id', ['initial_status_option']);
      }])->forSelect();
    }]);

    $keys = [
      'estimate' => $project->estimate,
      'estimate-options' => $project->estimate->estimateOptions,
      'status' => $project->status,
      'status-options' => $project->status->statusOptions,
    ];

    try {
      if ($key) {
        return response()->json([$key => $keys[$key]], 200);
      }

      return response()->json($keys, 200);
    } catch (Exception $ex) {
      Log::error($ex);

      return response()->json([$key => []], 200);
    }
  }

  protected function constructBreadcrumbs(string $path = null, array $additional = []): Collection {
    $breadcrumbs = collect([(object)['label' => 'Projects', 'path' => route('projects.index')]]);

    if ($path === 'create') {
      $breadcrumbs->push((object)['label' => 'Create Project', 'path' => route('projects.create')]);
    } elseif ($path === 'show' || $path === 'edit') {
      $breadcrumbs->push((object)['label' => 'View Project', 'path' => route('projects.show', $additional['project'])]);
      if ($path == 'edit') {
        $breadcrumbs->push((object)['label' => 'Edit Project', 'path' => route('projects.edit', $additional['project'])]);
      }
    }

    $breadcrumbs->last()->active = true;

    return $breadcrumbs;
  }
}
