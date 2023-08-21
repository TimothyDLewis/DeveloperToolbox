@extends('layouts.app')
@include('components.title', ['title' => 'Edit Resource'])

@section('body')
  @include('resources.components.header', ['resourceContext' => $resource])
  <div class="card mb-3">
    <div class="card-header">Edit Resource</div>
    <div class="card-body">
      <form id="resourceForm" method="POST" action="{{ route('resources.update', $resource) }}">
        @csrf
        @method('PATCH')
        @include('resources.components.form', ['resource' => $resource])
      </form>
    </div>
  </div>
@endsection
