@extends('layouts.app')
@include('components.title', ['title' => 'View Status'])

@section('body')
  @include('statuses.components.header', ['statusContext' => $status])
  <div class="card mb-3">
    <div class="card-header">
      View Status
    </div>
    <div class="card-body mb-0">
      <div class="row">
        <div class="col-12 mb-3">
          <label class="form-label">Title</label>
          <p class="card card-body card-condensed">{{ $status->title }}</p>
        </div>
        <div class="col-12 mb-3">
          <label class="form-label">Description</label>
          <p class="card card-body card-condensed">{!! nl2br($status->description ?? '<i class="text-secondary">No description provided...</i>') !!}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Created At</label>
          <p class="card card-body card-condensed d-block">{!! $status->created_display !!}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Updated At</label>
          <p class="card card-body card-condensed d-block">{!! $status->updated_display !!}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="nav nav-pills nav-fill mb-3" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button">Status Options</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" tabindex="-1">Projects</button>
          </div>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
              <table id="statusOptions" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center mb-0">
                <thead>
                  <tr>
                    <th class="th-min text-center">ID</th>
                    <th>Label</th>
                    <th>Description</th>
                    <th>Text Color</th>
                    <th>Background Color</th>
                    <th>Initial</th>
                    <th>Previous</th>
                    <th>Next</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($status->statusOptions as $statusOption)
                    <tr>
                      <td class="td-min text-center">{{ $statusOption->id }}</td>
                      <td>
                        <h6 class="mb-0">{!! $statusOption->badge_display !!}</h6>
                      </td>
                      <td>
                        {!! $statusOption->description ?? '<i class="text-secondary">No description provided...</i>' !!}
                      </td>
                      <td>{{ $statusOption->text_color }}</td>
                      <td>{{ $statusOption->background_color }}</td>
                      <td  class="td-min text-center">
                        <i class="fa-solid fa-{{ $statusOption->initial_status_option ? 'circle-check' : 'circle-xmark text-secondary' }}"></i>
                      </td>
                      <td>
                        @if($statusOption->previousStatusOption)
                          <h6 class="mb-0">{!! $statusOption->previousStatusOption->badge_display !!}</h6>
                        @else
                          <i class="text-secondary">None</i>
                        @endif
                      </td>
                      <td>
                        @if($statusOption->nextStatusOption)
                          <h6 class="mb-0">{!! $statusOption->nextStatusOption->badge_display !!}</h6>
                        @else
                          <i class="text-secondary">None</i>
                        @endif
                      </td>
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
                    <th>Source Code Management (SCM) URL</th>
                    <th>Estimate</th>
                    <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($status->projects as $project)
                      <tr>
                        <td class="td-min text-center">{{ $project->id }}</td>
                        <td>
                          <a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a>
                        </td>
                        <td>{{ $project->code }}</td>
                        <td>{!! $project->scm_url_display !!}</td>
                        <td>
                          <a href="{{ route('estimates.show', $project->estimate) }}">{{ $project->estimate->title }}</a>
                        </td>
                        <td>
                          {{ $project->status->title }}
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
  </div>
@endsection
