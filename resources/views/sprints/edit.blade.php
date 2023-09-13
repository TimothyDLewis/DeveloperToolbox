@extends('layouts.app')
@include('components.title', ['title' => 'Edit Sprint'])

@section('body')
  @include('sprints.components.header', ['sprintContext' => $sprint])
  <div class="card mb-3">
    <div class="card-header">Edit Sprint</div>
    <div class="card-body">
      <form id="sprintForm" method="POST" action="{{ route('sprints.update', $sprint) }}" novalidate>
        @csrf
        @method('PATCH')
        @include('sprints.components.form', ['sprint' => $sprint])
      </form>
    </div>
  </div>
@endsection
