@extends('layouts.app')
@include('components.title', ['title' => 'Sprints'])

@section('body')
  @include('sprints.components.header')
  <div class="card mb-3">
    <div class="card-header">All Sprints</div>
    <div class="card-body table-responsive">
      <table id="sprints" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center {{ $sprints->hasPages() ? 'mb-3' : 'mb-0' }}">
        <thead>
          <tr>
            <th class="th-min text-center">ID</th>
            <th>Title</th>
            <th class="th-start-date text-center">Start</th>
            <th class="th-end-date text-center">End</th>
            <th class="th-min text-center">Issues</th>
            <th class="th-min text-center">Occurrences</th>
            <th class="th-min text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($sprints as $sprint)
            <tr>
              <td class="td-min text-center">{{ $sprint->id }}</td>
              <td>
                <a href="{{ route('sprints.show', $sprint) }}">{{ $sprint->title }}</a>
              </td>
              <td class="td-start-date">{!! $sprint->start_date_display !!}</td>
              <td class="td-end-date">{!! $sprint->end_date_display !!}</td>
              <td class="td-min text-center">{!! $sprint->issues_count_display !!}</td>
              <td class="td-min text-center">{!! $sprint->occurrences_count_display !!}</td>
              <td class="td-min">
                <div class="btn-group">
                  <a href="{{ route('scheduler.sprint', $sprint) }}" class="btn btn-link">
                    <i class="text-success fa-regular fa-calendar"></i>
                  </a>
                  <a href="{{ route('sprints.edit', $sprint) }}" class="btn btn-link">
                    <i class="text-primary fa-regular fa-pen"></i>
                  </a>
                  <form action="{{ route('sprints.destroy', $sprint) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="button" class="btn btn-link text-danger delete-sprint">
                      <i class="text-danger fa-regular fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7">
                <i class="text-secondary">No Sprints...</i>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
      {{ $sprints->links() }}
    </div>
  </div>
@endsection
