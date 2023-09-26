@extends('layouts.app')
@include('components.title', ['title' => 'Scheduler'])

@section('body')
  <div id="schedulerWrapper" class="d-flex flex-nowrap">
    @include('components.navigation.scheduler.sidebar', ['issues' => $issues])
    <div class="container-fluid">
      @include('components.session-flash', ['containerClass' => 'mt-3'])
      <div id="schedulerContainer" @if($sprint) data-sprint="{{ $sprint }}" @endif data-js-paths="{{ $jsPaths->toJson() }}">
        <div id="scheduler" class="mt-3 mb-2"></div>
      </div>
    </div>
  </div>
@endsection
