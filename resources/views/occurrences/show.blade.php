@extends('layouts.app')
@include('components.title', ['title' => 'Occurrences'])

@section('body')
  @include('occurrences.components.header', ['occurrenceContext' => $occurrence])
  <div class="card mb-3">
    <div class="card-header">
      View Occurrence
    </div>
    <div class="card-body mb-0">
      <div class="row">
        <div class="col-12 {{ $occurrence->sprint ? 'col-sm-5' : 'col-sm-10' }} mb-3">
          <label class="form-label">Event</label>
          <p class="card card-body card-condensed">{!! $occurrence->event_display !!}</p>
        </div>
        @if($occurrence->sprint)
          <div class="col-12 col-sm-5 mb-3">
            <label class="form-label">Sprint</label>
            <p class="card card-body card-condensed">{!! $occurrence->sprint_display !!}</p>
          </div>
        @endif
        <div class="col-12 col-sm-2 mb-3">
          <label class="form-label d-block">Duration</label>
          <h6 class="mt-3">{!! $occurrence->duration_display !!}</h6>
        </div>
        <div class="col-12 col-sm-2 mb-3">
          <label class="form-label d-block">All Day</label>
          <i class="fa-solid fa-{{ $occurrence->all_day ? 'circle-check' : 'circle-xmark text-secondary' }} mt-2"></i>
        </div>
        <div class="col-12 {{ $occurrence->all_day ? 'col-sm-10' : 'col-sm-5' }} mb-3">
          <label class="form-label">Start</label>
          <p class="card card-body card-condensed d-block">{!! $occurrence->all_day ? $occurrence->start_date_time_as_date_display : $occurrence->start_datetime_display !!}</p>
        </div>
        @if(!$occurrence->all_day)
          <div class="col-12 col-sm-5 mb-3">
            <label class="form-label">End</label>
            <p class="card card-body card-condensed d-block">{!! $occurrence->end_datetime_display !!}</p>
          </div>
        @endif
        <div class="col-12 col-sm-6 mb-0">
          <label class="form-label">Created At</label>
          <p class="card card-body card-condensed d-block">{!! $occurrence->created_at_display !!}</p>
        </div>
        <span class="d-block d-sm-none mb-3"></span>
        <div class="col-12 col-sm-6 mb-0">
          <label class="form-label">Updated At</label>
          <p class="card card-body card-condensed d-block">{!! $occurrence->updated_at_display !!}</p>
        </div>
      </div>
    </div>
@endsection
