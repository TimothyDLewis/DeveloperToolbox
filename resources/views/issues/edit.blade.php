@extends('layouts.app')
@include('components.title', ['title' => 'Edit Issue'])

@section('body')
  @include('issues.components.header', ['issueContext' => $issue])
  <div class="card mb-3">
    <div class="card-header">Edit Issue</div>
    <div class="card-body">
      <form id="issueForm" method="POST" action="{{ route('issues.update', $issue) }}">
        @csrf
        @method('PATCH')
        @include('issues.components.form', ['issue' => $issue])
      </form>
    </div>
  </div>
@endsection
