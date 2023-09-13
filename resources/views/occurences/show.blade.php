@extends('layouts.app')
@include('components.title', ['title' => 'Occurences'])

@section('body')
  @include('occurences.components.header', ['occurenceContext' => $occurence])
  <div class="card mb-3">
    <div class="card-header">
      View Occurence
    </div>
    <div class="card-body mb-0">
      <div class="row">
        <div class="col-12 col-sm-9 mb-3">
          <label class="form-label">Event</label>
          <p class="card card-body card-condensed">{!! $occurence->event_display !!}</p>
        </div>
        <div class="col-12 col-sm-3 mb-3">
          <label class="form-label d-block">Duration</label>
          <h6 class="mt-3">{!! $occurence->duration_display !!}</h6>
        </div>
        <div class="col-12 col-sm-2 mb-3">
          <label class="form-label d-block">All Day</label>
          <i class="fa-solid fa-{{ $occurence->all_day ? 'circle-check' : 'circle-xmark text-secondary' }} mt-2"></i>
        </div>
        <div class="col-12 {{ $occurence->all_day ? 'col-sm-10' : 'col-sm-5' }} mb-3">
          <label class="form-label">Start</label>
          <p class="card card-body card-condensed d-block">{!! $occurence->all_day ? $occurence->start_date_time_as_date_display : $occurence->start_datetime_display !!}</p>
        </div>
        @if(!$occurence->all_day)
          <div class="col-12 col-sm-5 mb-3">
            <label class="form-label">End</label>
            <p class="card card-body card-condensed d-block">{!! $occurence->end_datetime_display !!}</p>
          </div>
        @endif
        <div class="col-12 col-sm-6 mb-0">
          <label class="form-label">Created At</label>
          <p class="card card-body card-condensed d-block">{!! $occurence->created_at_display !!}</p>
        </div>
        <span class="d-block d-sm-none mb-3"></span>
        <div class="col-12 col-sm-6 mb-0">
          <label class="form-label">Updated At</label>
          <p class="card card-body card-condensed d-block">{!! $occurence->updated_at_display !!}</p>
        </div>
      </div>
    </div>
@endsection
