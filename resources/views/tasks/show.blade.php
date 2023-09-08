@extends('layouts.app')
@include('components.title', ['title' => 'Tasks'])

@section('body')
  @include('tasks.components.header', ['taskContext' => $task])
  <div class="card mb-3">
    <div class="card-header">
      View Task
    </div>
    <div class="card-body mb-0">
      <div class="row">
        <div class="col-12 col-sm-9 mb-3">
          <label class="form-label">Issue</label>
          <p class="card card-body card-condensed">{!! $task->issue_display !!}</p>
        </div>
        <div class="col-12 col-sm-3 mb-3">
          <label class="form-label d-block">Duration</label>
          <h6 class="mt-3">{!! $task->duration_display !!}</h6>
        </div>
        <div class="col-12 col-sm-5 mb-3">
          <label class="form-label">Start</label>
          <p class="card card-body card-condensed d-block">{!! $task->start_datetime_display !!}</p>
        </div>
        <div class="col-12 col-sm-5 mb-3">
          <label class="form-label">End</label>
          <p class="card card-body card-condensed d-block">{!! $task->end_datetime_display !!}</p>
        </div>
        <div class="col-12 col-sm-2 mb-3">
          <label class="form-label d-block">Logged</label>
          <i class="fa-solid fa-{{ $task->logged ? 'circle-check' : 'circle-xmark text-secondary' }} mt-2"></i>
        </div>
        <div class="col-12 mb-3">
          <label class="form-label">Description</label>
          <p class="card card-body card-condensed">{!! nl2br($task->description_display) !!}</p>
        </div>
        <div class="col-12 col-sm-6 mb-0">
          <label class="form-label">Created At</label>
          <p class="card card-body card-condensed d-block">{!! $task->created_at_display !!}</p>
        </div>
        <span class="d-block d-sm-none mb-3"></span>
        <div class="col-12 col-sm-6 mb-0">
          <label class="form-label">Updated At</label>
          <p class="card card-body card-condensed d-block">{!! $task->updated_at_display !!}</p>
        </div>
      </div>
    </div>
@endsection
