@extends('layouts.app')
@include('components.title', ['title' => 'Create Project'])

@section('body')
  @include('projects.components.header', ['projectContext' => $project])
  <form method="POST" class="p-2" action="{{ route('projects.update', $project) }}">
    @csrf
    @method('PATCH')
    @include('projects.components.form', ['project' => $project])
  </form>
@endsection
