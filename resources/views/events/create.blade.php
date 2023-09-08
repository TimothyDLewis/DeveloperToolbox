@extends('layouts.app')
@include('components.title', ['title' => 'Create Event'])

@section('body')
  @include('events.components.header')
  <div class="card mb-3">
    <div class="card-header">New Event</div>
    <div class="card-body">
      <form id="eventForm" method="POST" action="{{ route('events.store') }}" data-event-type="{{ route('event-types.show', ['event_type' => ':event_type_id']) }}" novalidate>
        @csrf
        @include('events.components.form', ['event' => $event])
      </form>
    </div>
  </div>
@endsection
