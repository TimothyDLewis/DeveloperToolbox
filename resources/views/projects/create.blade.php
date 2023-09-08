@extends('layouts.app')
@include('components.title', ['title' => 'Create Project'])

@section('body')
  @include('projects.components.header')
  <div class="card mb-3">
    <div class="card-header">New Project</div>
    <div class="card-body">
      <form id="projectForm" method="POST" action="{{ route('projects.store') }}">
        @csrf
        @include('projects.components.form', ['project' => $project])
      </form>
    </div>
  </div>
@endsection
