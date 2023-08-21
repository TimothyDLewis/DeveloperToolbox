@extends('layouts.app')
@include('components.title', ['title' => 'Create Resource'])

@section('body')
  @include('resources.components.header')
  <div class="card mb-3">
    <div class="card-header">New Resource</div>
    <div class="card-body">
      <form id="resourceForm" method="POST" action="{{ route('resources.store') }}">
        @csrf
        @include('resources.components.form', ['resource' => $resource])
      </form>
    </div>
  </div>
@endsection
