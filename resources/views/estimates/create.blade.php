@extends('layouts.app')
@include('components.title', ['title' => 'New Estimate'])

@section('body')
  @include('estimates.components.header')
  <div class="card mb-3">
    <div class="card-header">New Estimate</div>
    <div class="card-body">
      <form id="estimateForm" method="POST" action="{{ route('estimates.store') }}">
        @csrf
        @include('estimates.components.form', ['estimate' => $estimate])
      </form>
    </div>
  </div>
@endsection
