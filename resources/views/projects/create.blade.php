@extends('layouts.app')
@include('components.title', ['title' => 'Create Project'])

@section('body')
  @include('projects.components.header')
  <form method="POST" class="p-2" action="{{ route('projects.store') }}">
    @csrf
    @include('projects.components.form', ['project' => $project])
  </form>
@endsection
