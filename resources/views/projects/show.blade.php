@extends('layouts.app')
@include('components.title', ['title' => 'View Project'])

@section('body')
  @include('projects.components.header', ['projectContext' => $project])
  <div class="card mb-3">
    <div class="card-header">
      View Project
    </div>
    <div class="card-body mb-0">
      <div class="row">
        <div class="col-12 mb-3">
          <label class="form-label">Title</label>
          <p class="card card-body card-condensed">{{ $project->title }}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Code</label>
          <p class="card card-body card-condensed">{{ $project->code }}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Source Code Management (SCM) URL</label>
          <p class="card card-body card-condensed">{!! $project->scm_url_display !!}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Estimate</label>
          <p class="card card-body card-condensed">
            <a href="{{ route('estimates.show', $project->estimate) }}">{{ $project->estimate->title }}</a>
          </p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Status</label>
          <p class="card card-body card-condensed">
            <a href="{{ route('statuses.show', $project->status) }}">{{ $project->status->title }}</a>
          </p>
        </div>
        <div class="col-12 mb-3">
          <label class="form-label">Description</label>
          <p class="card card-body card-condensed">{!! nl2br($project->description ?? '<i class="text-secondary">No description provided...</i>') !!}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Created At</label>
          <p class="card card-body card-condensed d-block">{!! $project->created_display !!}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Updated At</label>
          <p class="card card-body card-condensed d-block">{!! $project->updated_display !!}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="nav nav-pills nav-fill mb-3" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button">Issues</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" tabindex="-1">Resources</button>
          </div>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
              <table id="issues" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center mb-0">
                <thead>
                  <tr>
                    <th class="th-min text-center">ID</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($project->issues as $issue)
                  @empty
                    <tr>
                      <td colspan="1">No Connected Issues...</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
              <table id="projects" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center mb-0">
                <thead>
                  <tr>
                    <th class="th-min text-center">ID</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($project->resources as $resource)
                  @empty
                    <tr>
                      <td colspan="1">No Connected Projects...</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
