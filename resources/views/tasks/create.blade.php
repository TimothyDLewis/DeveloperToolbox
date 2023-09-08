@extends('layouts.app')
@include('components.title', ['title' => 'Create Task'])

@section('body')
  @include('tasks.components.header')
  <div class="card mb-3">
    <div class="card-header">New Task</div>
    <div class="card-body">
      <form id="taskForm" method="POST" action="{{ route('tasks.store') }}" novalidate>
        @csrf
        @include('tasks.components.form', ['task' => $task])
      </form>
    </div>
  </div>
@endsection
