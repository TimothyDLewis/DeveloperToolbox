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
          <p class="card card-body card-condensed">{!! nl2br($estimate->description_display) !!}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Created At</label>
          <p class="card card-body card-condensed d-block">{!! $estimate->created_at_display !!}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Updated At</label>
          <p class="card card-body card-condensed d-block">{!! $estimate->updated_at_display !!}</p>
        </div>
      </div>
      @include('estimates.components.tabs', ['estimate' => $estimate])
    </div>
  </div>
@endsection
