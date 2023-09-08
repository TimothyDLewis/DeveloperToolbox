@extends('layouts.app')
@include('components.title', ['title' => 'Edit Project'])

@section('body')
  @include('projects.components.header', ['projectContext' => $project])
  <div class="card mb-3">
    <div class="card-header">Edit Project</div>
    <div class="card-body">
      <form id="projectForm" method="POST" action="{{ route('projects.update', $project) }}">
        @csrf
        @method('PATCH')
        @include('projects.components.form', ['project' => $project])
      </form>
    </div>
  </div>
@endsection
