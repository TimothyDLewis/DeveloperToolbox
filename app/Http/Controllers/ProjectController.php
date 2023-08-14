<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Traits\Controllers\Breadcrumbs;

class ProjectController extends Controller {
  use Breadcrumbs;

  public function index() {
    return view('projects.index', $this->withBreadcrumbs());
  }

  public function create() {
    return view('projects.create', $this->withBreadcrumbs('create', includes: [
      'project' => new Project()
    ]));
  }

  public function store(Request $request) {

  }

  public function edit(Project $project) {

  }

  public function update(Request $request, Project $project) {

  }

  public function destroy(Project $project) {

  }

  private function constructBreadcrumbs(string $path = null, array $additional = []): Collection {
    $breadcrumbs = collect([(object)['label' => 'Projects', 'path' => route('projects.index')]]);

    if ($path == 'create') {
      $breadcrumbs->push((object)['label' => 'Create Project', 'path' => route('projects.create')]);
    } elseif ($path == 'edit') {
      $breadcrumbs->push((object)['label' => 'Edit Project', 'path' => route('projects.edit', $additional['project'])]);
    }

    $breadcrumbs->last()->active = true;

    return $breadcrumbs;
  }
}
