@extends('layouts.app')
@include('components.title', ['title' => 'Edit Estimate'])

@section('body')
  @include('estimates.components.header', ['estimateContext' => $estimate])
  <div class="card mb-3">
    <div class="card-header">Edit Estimate</div>
    <div class="card-body">
      <form id="estimateForm" method="POST" action="{{ route('estimates.update', $estimate) }}">
        @csrf
        @method('PATCH')
        @include('estimates.components.form', [
          'estimate' => $estimate
        ])
      </form>
    </div>
  </div>
@endsection
