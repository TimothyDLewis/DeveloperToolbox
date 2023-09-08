@extends('layouts.app')
@include('components.title', ['title' => 'Event Types'])

@section('body')
  @include('event-types.components.header', ['eventTypeContext' => $eventType])
  <div class="card mb-3">
    <div class="card-header">
      View Event Type
    </div>
    <div class="card-body mb-0">
      <div class="row">
        <div class="col-12 mb-3">
          <label class="form-label d-block">Title</label>
          <h6 class="mt-3">{!! $eventType->label_title_display !!}</h6>
        </div>
        <div class="col-12 col-sm-6 col-md-4 mb-3">
          <label class="form-label d-block">Text Color</label>
          {!! $eventType->text_color_display !!}
        </div>
        <div class="col-12 col-sm-6 col-md-4 mb-3">
          <label class="form-label d-block">Background Color</label>
          {!! $eventType->background_color_display !!}
        </div>
        <div class="col-12 col-sm-6 col-md-4 mb-3">
          <label class="form-label d-block">Affects Productivity</label>
          <i class="fa-solid fa-{{ $eventType->affects_productivity ? 'circle-check' : 'circle-xmark text-secondary' }} mt-2"></i>
        </div>
        <div class="col-12 mb-3">
          <label class="form-label">Description</label>
          <p class="card card-body card-condensed">{!! nl2br($eventType->description_display) !!}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Created At</label>
          <p class="card card-body card-condensed d-block">{!! $eventType->created_at_display !!}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Updated At</label>
          <p class="card card-body card-condensed d-block">{!! $eventType->updated_at_display !!}</p>
        </div>
      </div>
      @include('event-types.components.tabs', ['eventType' => $eventType])
    </div>
@endsection
