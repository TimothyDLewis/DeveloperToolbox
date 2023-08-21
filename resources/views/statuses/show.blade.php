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
          <p class="card card-body card-condensed">{!! nl2br($status->description_display) !!}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Created At</label>
          <p class="card card-body card-condensed d-block">{!! $status->created_at_display !!}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Updated At</label>
          <p class="card card-body card-condensed d-block">{!! $status->updated_at_display !!}</p>
        </div>
      </div>
      @include('statuses.components.tabs', ['status' => $status])
    </div>
  </div>
@endsection
