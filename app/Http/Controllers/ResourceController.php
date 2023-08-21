<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Project;
use App\Models\Resource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Traits\Controllers\Breadcrumbs;
use App\Http\Requests\Resources\StoreResourceRequest;
use App\Http\Requests\Resources\UpdateResourceRequest;

class ResourceController extends Controller {
  use Breadcrumbs;

  public function index(): View {
    return view('resources.index', $this->withBreadcrumbs(includes: ['resources' => Resource::with('project')->orderBy('slug')->paginate(10)]));
  }

  public function create(): View {
    return view('resources.create', $this->withBreadcrumbs(
      path: 'create',
      includes: [
        'projects' => Project::orderBy('slug')->forSelect()->get(),
        'resource' => new Resource()
      ]
    ));
  }

  public function store(StoreResourceRequest $request): RedirectResponse {
    try {
      Resource::create($request->validated());

      $this->sessionSuccess('<strong>Resource Created</strong>');

      return redirect()->route('resources.index');
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Create Resource</strong><br/><br/>Check logs for complete details.");

      return redirect()->back()->withInput();
    }
  }

  public function show(Resource $resource): View {
    $resource->load(['estimate', 'status']);

    return view('resources.show', $this->withBreadcrumbs(
      path: 'show',
      additional: ['resource' => $resource],
      includes: ['resource' => $resource]
    ));
  }

  public function edit(Resource $resource): View {
    return view('resources.edit', $this->withBreadcrumbs(
      path: 'edit',
      additional: ['resource' => $resource],
      includes: [
        'projects' => Project::orderBy('slug')->forSelect()->get(),
        'resource' => $resource
      ]
    ));
  }

  public function update(UpdateResourceRequest $request, Resource $resource): RedirectResponse {
    try {
      $resource->update($request->validated());
      $this->sessionSuccess('<strong>Resource Updated</strong>');

      return redirect()->route('resources.index');
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Update Resource</strong><br/><br/>Check logs for complete details.");

      return redirect()->back()->withInput();
    }
  }

  public function destroy(Resource $resource): RedirectResponse {
    try {
      $resource->delete();

      $this->sessionSuccess('<strong>Resource Deleted</strong>');

      return redirect()->route('resources.index');
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Delete Resource</strong><br/><br/>Check logs for complete details.");

      return redirect()->back();
    }
  }

  private function constructBreadcrumbs(string $path = null, array $additional = []): Collection {
    $breadcrumbs = collect([(object)['label' => 'Resources', 'path' => route('resources.index')]]);

    if ($path === 'create') {
      $breadcrumbs->push((object)['label' => 'Create Resource', 'path' => route('resources.create')]);
    } elseif ($path === 'edit') {
      $breadcrumbs->push((object)['label' => 'Edit Resource', 'path' => route('resources.edit', $additional['resource'])]);
    }

    $breadcrumbs->last()->active = true;

    return $breadcrumbs;
  }
}
