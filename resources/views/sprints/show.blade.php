@extends('layouts.app')
@include('components.title', ['title' => 'View Sprint'])

@section('body')
  @include('sprints.components.header', ['sprintContext' => $sprint])
  <div class="card mb-3">
    <div class="card-header">
      View Sprint
    </div>
    <div class="card-body mb-0">
      <div class="row">
        <div class="col-12 mb-3">
          <label class="form-label">Title</label>
          <p class="card card-body card-condensed">{{ $sprint->title }}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Start</label>
          <p class="card card-body card-condensed d-block">{!! $sprint->start_date_display !!}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">End</label>
          <p class="card card-body card-condensed d-block">{!! $sprint->end_date_display !!}</p>
        </div>
        <div class="col-12 mb-3">
          <label class="form-label">Description</label>
          <p class="card card-body card-condensed">{!! nl2br($sprint->description_display) !!}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Created At</label>
          <p class="card card-body card-condensed d-block">{!! $sprint->created_at_display !!}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Updated At</label>
          <p class="card card-body card-condensed d-block">{!! $sprint->updated_at_display !!}</p>
        </div>
      </div>
      @include('sprints.components.tabs', ['sprint' => $sprint])
    </div>
  </div>
@endsection
