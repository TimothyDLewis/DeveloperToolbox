@extends('layouts.app')
@include('components.title', ['title' => 'Edit Event Type'])

@section('body')
  @include('event-types.components.header', ['eventTypeContext' => $eventType])
  <div class="card mb-3">
    <div class="card-header">Edit Event Type</div>
    <div class="card-body">
      <form id="eventTypeForm" method="POST" action="{{ route('event-types.update', $eventType) }}">
        @csrf
        @method('PATCH')
        @include('event-types.components.form', ['eventType' => $eventType])
      </form>
    </div>
  </div>
@endsection
