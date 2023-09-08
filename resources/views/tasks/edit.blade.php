@extends('layouts.app')
@include('components.title', ['title' => 'Edit Task'])

@section('body')
  @include('tasks.components.header', ['taskContext' => $task])
  <div class="card mb-3">
    <div class="card-header">Edit Task</div>
    <div class="card-body">
      <form id="taskForm" method="POST" action="{{ route('tasks.update', $task) }}" novalidate>
        @csrf
        @method('PATCH')
        @include('tasks.components.form', ['task' => $task])
      </form>
    </div>
  </div>
@endsection
