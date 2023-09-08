@extends('layouts.app')
@include('components.title', ['title' => 'Edit Occurence'])

@section('body')
  @include('occurences.components.header', ['occurenceContext' => $occurence])
  <div class="card mb-3">
    <div class="card-header">Edit Occurence</div>
    <div class="card-body">
      <form id="occurenceForm" method="POST" action="{{ route('occurences.update', $occurence) }}" novalidate>
        @csrf
        @method('PATCH')
        @include('occurences.components.form', ['occurence' => $occurence])
      </form>
    </div>
  </div>
@endsection
