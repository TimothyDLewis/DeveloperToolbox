@extends('layouts.app')
@include('components.title', ['title' => 'Create Issue'])

@section('body')
  @include('issues.components.header')
  <div class="card mb-3">
    <div class="card-header">New Issue</div>
    <div class="card-body">
      <form id="issueForm" method="POST" action="{{ route('issues.store') }}" data-project-select-options="{{ route('projects.select-options', ['project' => ':project_id']) }}">
        @csrf
        @include('issues.components.form', ['issue' => $issue])
      </form>
    </div>
  </div>
@endsection
