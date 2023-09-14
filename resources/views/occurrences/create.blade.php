@extends('layouts.app')
@include('components.title', ['title' => 'Create Occurrence'])

@section('body')
  @include('occurrences.components.header')
  <div class="card mb-3">
    <div class="card-header">New Occurrence</div>
    <div class="card-body">
      <form id="occurrenceForm" method="POST" action="{{ route('occurrences.store') }}" novalidate>
        @csrf
        @include('occurrences.components.form', ['occurrence' => $occurrence])
      </form>
    </div>
  </div>
@endsection
