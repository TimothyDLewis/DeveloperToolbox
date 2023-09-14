@extends('layouts.app')
@include('components.title', ['title' => 'Edit Occurrence'])

@section('body')
  @include('occurrences.components.header', ['occurrenceContext' => $occurrence])
  <div class="card mb-3">
    <div class="card-header">Edit Occurrence</div>
    <div class="card-body">
      <form id="occurrenceForm" method="POST" action="{{ route('occurrences.update', $occurrence) }}" novalidate>
        @csrf
        @method('PATCH')
        @include('occurrences.components.form', ['occurrence' => $occurrence])
      </form>
    </div>
  </div>
@endsection
