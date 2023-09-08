@extends('layouts.app')
@include('components.title', ['title' => 'Edit Event'])

@section('body')
  @include('events.components.header', ['eventContext' => $event])
  <div class="card mb-3">
    <div class="card-header">Edit Event</div>
    <div class="card-body">
      <form id="eventForm" method="POST" action="{{ route('events.update', $event) }}" data-event-type="{{ route('event-types.show', ['event_type' => ':event_type_id']) }}" novalidate>
        @csrf
        @method('PATCH')
        @include('events.components.form', ['event' => $event])
      </form>
    </div>
  </div>
@endsection
