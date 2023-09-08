@extends('layouts.app')
@include('components.title', ['title' => 'Create Event Type'])

@section('body')
  @include('event-types.components.header')
  <div class="card mb-3">
    <div class="card-header">New Event Type</div>
    <div class="card-body">
      <form id="eventTypeForm" method="POST" action="{{ route('event-types.store') }}">
        @csrf
        @include('event-types.components.form', ['eventType' => $eventType])
      </form>
    </div>
  </div>
@endsection
