@extends('layouts.app')
@include('components.title', ['title' => 'View Issue'])

@section('body')
  @include('issues.components.header', ['issueContext' => $issue])
  <div class="card mb-3">
    <div class="card-header">
      View Issue
    </div>
    <div class="card-body mb-0">
      <div class="row">
        <div class="col-12 mb-3">
          <label class="form-label">Title</label>
          <p class="card card-body card-condensed">{{ $issue->title }}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Code</label>
          <p class="card card-body card-condensed">{{ $issue->code }}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">External URL</label>
          {!! $issue->external_url_display !!}
        </div>
        <div class="col-12 col-sm-6 col-md-4 mb-3">
          <label class="form-label">Project</label>
          <p class="card card-body card-condensed">{!! $issue->project_display !!}</p>
        </div>
        <div class="col-12 col-sm-6 col-md-4 mb-3">
          <label class="form-label d-block">
            Estimate Option
            <a class="external-link ms-2" href="{{ route('estimates.show', $issue->project->estimate) }}">
              <small>{{ $issue->project->estimate->title }}</small>
            </a>
          </label>
          <h6 class="mt-3 mb-0">{!! $issue->estimateOption->label_display_alt !!}</h6>
        </div>
        <div class="col-12 col-sm-6 col-md-4 mb-3">
          <label class="form-label d-block">
            Status Option
            <a class="external-link ms-2" href="{{ route('statuses.show', $issue->project->status) }}">
              <small>{{ $issue->project->status->title }}</small>
            </a>
          </label>
          <h6 class="mt-3 mb-0">{!! $issue->statusOption->label_display !!}</h6>
        </div>
        <div class="col-12 mb-3">
          <label class="form-label">Description</label>
          <p class="card card-body card-condensed">{!! nl2br($issue->description_display) !!}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Created At</label>
          <p class="card card-body card-condensed d-block">{!! $issue->created_at_display !!}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Updated At</label>
          <p class="card card-body card-condensed d-block">{!! $issue->updated_at_display !!}</p>
        </div>
      </div>
      @include('issues.components.tabs', ['issue' => $issue])
    </div>
  </div>
@endsection
