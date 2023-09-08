@extends('layouts.app')
@include('components.title', ['title' => 'Create Occurence'])

@section('body')
  @include('occurences.components.header')
  <div class="card mb-3">
    <div class="card-header">New Occurence</div>
    <div class="card-body">
      <form id="occurenceForm" method="POST" action="{{ route('occurences.store') }}" novalidate>
        @csrf
        @include('occurences.components.form', ['occurence' => $occurence])
      </form>
    </div>
  </div>
@endsection
