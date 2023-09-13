<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Issue;
use App\Models\Project;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Traits\Controllers\Breadcrumbs;
use App\Http\Requests\Issues\StoreIssueRequest;
use App\Http\Requests\Issues\UpdateIssueRequest;

class IssueController extends Controller {
  use Breadcrumbs;

  public function index(): View {
    return view('issues.index', $this->withBreadcrumbs(includes: ['issues' => Issue::with(['estimateOption', 'project', 'statusOption'])->withCount(['tasks', 'sprints'])->orderBy('id')->paginate(30)]));
  }

  public function create(): View {
    $estimateOptions = collect();
    $statusOptions = collect();

    if (old('project_id')) {
      $project = Project::with(['estimate.estimateOptions', 'status.statusOptions'])->find(old('project_id'));

      $estimateOptions = $project->estimate->estimateOptions;
      $statusOptions = $project->status->statusOptions;
    }

    return view('issues.create', $this->withBreadcrumbs(
      path: 'create',
      includes: [
        'estimateOptions' => $estimateOptions,
        'projects' => Project::orderBy('id')->forSelect()->get(),
        'issue' => new Issue(),
        'statusOptions' => $statusOptions
      ]
    ));
  }

  public function store(StoreIssueRequest $request): RedirectResponse {
    try {
      Issue::create($request->validated());

      $this->sessionSuccess('<strong>Issue Created</strong>');

      return redirect()->route('issues.index');
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Create Issue</strong><br/><br/>Check logs for complete details.");

      return redirect()->back()->withInput();
    }
  }

  public function show(Issue $issue): View {
    $issue->load(['project' => function ($query) {
      return $query->with(['estimate', 'status']);
    }, 'estimateOption', 'statusOption'])->loadCount(['tasks', 'sprints']);

    return view('issues.show', $this->withBreadcrumbs(
      path: 'show',
      additional: ['issue' => $issue],
      includes: ['issue' => $issue]
    ));
  }

  public function edit(Issue $issue): View {
    $issue->load(['project' => function ($query) {
      return $query->with(['status.statusOptions', 'estimate.estimateOptions']);
    }]);

    return view('issues.edit', $this->withBreadcrumbs(
      path: 'edit',
      additional: ['issue' => $issue],
      includes: [
        'estimateOptions' => $issue->project->estimate->estimateOptions,
        'issue' => $issue,
        'statusOptions' => $issue->project->status->statusOptions
      ]
    ));
  }

  public function update(UpdateIssueRequest $request, Issue $issue): RedirectResponse {
    try {
      $issue->update($request->validated());
      $this->sessionSuccess('<strong>Issue Updated</strong>');

      return redirect()->route('issues.show', $issue);
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Update Issue</strong><br/><br/>Check logs for complete details.");

      return redirect()->back()->withInput();
    }
  }

  public function destroy(Issue $issue): RedirectResponse {
    try {
      $issue->delete();

      $this->sessionSuccess('<strong>Issue Deleted</strong>');

      return redirect()->route('issues.index');
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Delete Issue</strong><br/><br/>Check logs for complete details.");

      return redirect()->back();
    }
  }

  private function constructBreadcrumbs(string $path = null, array $additional = []): Collection {
    $breadcrumbs = collect([(object)['label' => 'Issues', 'path' => route('issues.index')]]);

    if ($path === 'create') {
      $breadcrumbs->push((object)['label' => 'Create Issue', 'path' => route('issues.create')]);
    } elseif ($path === 'show' || $path === 'edit') {
      $breadcrumbs->push((object)['label' => 'View Issue', 'path' => route('issues.show', $additional['issue'])]);
      if ($path == 'edit') {
        $breadcrumbs->push((object)['label' => 'Edit Issue', 'path' => route('issues.edit', $additional['issue'])]);
      }
    }

    $breadcrumbs->last()->active = true;

    return $breadcrumbs;
  }
}
