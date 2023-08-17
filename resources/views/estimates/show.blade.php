@extends('layouts.app')
@include('components.title', ['title' => 'View Estimate'])

@section('body')
  @include('estimates.components.header', ['estimateContext' => $estimate])
  <div class="card mb-3">
    <div class="card-header">
      View Estimate
    </div>
    <div class="card-body mb-0">
      <div class="row">
        <div class="col-12 mb-3">
          <label class="form-label">Title</label>
          <p class="card card-body card-condensed">{{ $estimate->title }}</p>
        </div>
        <div class="col-12 mb-3">
          <label class="form-label">Description</label>
          <p class="card card-body card-condensed">{!! nl2br($estimate->description ?? '<i class="text-secondary">No description provided...</i>') !!}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Created At</label>
          <p class="card card-body card-condensed d-block">{!! $estimate->created_display !!}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Updated At</label>
          <p class="card card-body card-condensed d-block">{!! $estimate->updated_display !!}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="nav nav-pills nav-fill mb-3" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button">Estimate Options</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" tabindex="-1">Projects</button>
          </div>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
              <table id="estimateOptions" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center mb-0">
                <thead>
                  <tr>
                    <th class="th-min text-center">ID</th>
                    <th>Label</th>
                    <th>Value</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($estimate->estimateOptions as $estimateOption)
                    <tr>
                      <td class="td-min text-center">{{ $estimateOption->id }}</td>
                      <td>{{ $estimateOption->label }}</td>
                      <td>{{ $estimateOption->value }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
              <table id="projects" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center mb-0">
                <thead>
                  <tr>
                    <th class="th-min text-center">ID</th>
                    <th>Title</th>
                    <th>Code</th>
                    <th>Source Code Management (SCM) URL
                    <th>Estimate</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($estimate->projects as $project)
                    <tr>
                      <td class="td-min text-center">{{ $project->id }}</td>
                      <td>
                        <a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a>
                      </td>
                      <td>{{ $project->code }}</td>
                      <td>{!! $project->scm_url_display !!}</td>
                      <td>
                        {{ $project->estimate->title }}
                      </td>
                      <td>
                        <a href="{{ route('statuses.show', $project->status) }}">{{ $project->status->title }}</a>
                      </td>
                      <td class="td-min">
                        <div class="btn-group">
                          <a href="{{ route('projects.edit', $project) }}" class="btn btn-link">
                            <i class="text-primary fa-regular fa-pen"></i>
                          </a>
                          <a href="#" class="btn btn-link">
                            <i class="text-danger fa-regular fa-trash"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6">No Connected Projects...</td>
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
