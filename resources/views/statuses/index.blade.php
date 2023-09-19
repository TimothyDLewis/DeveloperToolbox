@extends('layouts.app')
@include('components.title', ['title' => 'Statuses'])

@section('body')
  @include('statuses.components.header')
  <div class="card mb-3">
    <div class="card-header">All Statuses</div>
    <div class="card-body">
      <table id="statuses" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center {{ $statuses->hasPages() ? 'mb-3' : 'mb-0' }}">
        <thead>
          <tr>
            <th class="th-min text-center">ID</th>
            <th>Title</th>
            <th class="th-status-options text-center">Status Options</th>
            <th class="th-min text-center">Projects</th>
            <th class="th-min text-center">Actions</th>
            <th class="th-touched text-center text-secondary">
              <i class="fa-solid fa-clock-rotate-left fa-flip-horizontal"></i>
            </th>
          </tr>
        </thead>
        <tbody>
          @forelse($statuses as $status)
            <tr>
              <td class="td-min text-center">{{ $status->id }}</td>
              <td>
                <a href="{{ route('statuses.show', $status) }}">{{ $status->title }}</a>
              </td>
              <td class="td-status-options text-center">{!! $status->status_options_count_display !!}</td>
              <td class="td-min text-center">{!! $status->projects_count_display !!}</td>
              <td class="td-min">
                <div class="btn-group">
                  <a href="{{ route('statuses.edit', $status) }}" class="btn btn-link">
                    <i class="text-primary fa-regular fa-pen"></i>
                  </a>
                  <form action="{{ route('statuses.destroy', $status) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="button" class="btn btn-link text-danger delete-status">
                      <i class="text-danger fa-regular fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
              <td class="td-touched text-center">
                {!! $status->touched_display !!}
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6">
                <i class="text-secondary">No Statuses...</i>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
      {{ $statuses->links() }}
    </div>
  </div>
@endsection
