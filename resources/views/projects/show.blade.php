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
          {!! $project->source_code_management_url_display !!}
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Estimate</label>
          <p class="card card-body card-condensed">{!! $project->estimate_display !!}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Status</label>
          <p class="card card-body card-condensed">{!! $project->status_display !!}</p>
        </div>
        <div class="col-12 mb-3">
          <label class="form-label">Description</label>
          <p class="card card-body card-condensed">{!! nl2br($project->description_display) !!}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Created At</label>
          <p class="card card-body card-condensed d-block">{!! $project->created_at_display !!}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Updated At</label>
          <p class="card card-body card-condensed d-block">{!! $project->updated_at_display !!}</p>
        </div>
      </div>
      @include('projects.components.tabs', ['project' => $project])
    </div>
  </div>
@endsection
