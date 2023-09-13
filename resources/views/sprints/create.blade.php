@extends('layouts.app')
@include('components.title', ['title' => 'Create Sprint'])

@section('body')
  @include('sprints.components.header')
  <div class="card mb-3">
    <div class="card-header">New Sprint</div>
    <div class="card-body">
      <form id="sprintForm" method="POST" action="{{ route('sprints.store') }}" novalidate>
        @csrf
        @include('sprints.components.form', ['sprint' => $sprint])
      </form>
    </div>
  </div>
@endsection
