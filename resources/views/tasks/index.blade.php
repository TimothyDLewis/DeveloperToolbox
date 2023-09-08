@extends('layouts.app')
@include('components.title', ['title' => 'Tasks'])

@section('body')
  @include('tasks.components.header')
  <div class="card mb-3">
    <div class="card-header">All Tasks</div>
    <div class="card-body table-responsive">
      <table id="tasks" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center {{ $tasks->hasPages() ? 'mb-3' : 'mb-0' }}">
        <thead>
          <tr>
            <th class="th-min text-center">ID</th>
            <th>Issue</th>
            <th class="th-start-datetime text-center">Start</th>
            <th class="th-end-datetime text-center">End</th>
            <th class="th-logged text-center">Logged</th>
            <th class="th-duration text-center">Duration</th>
            <th class="th-min text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($tasks as $task)
            <tr>
              <td class="td-min text-center">
                <a class="id-link" href="{{ route('tasks.show', $task) }}">{{ $task->id }}</a>
              </td>
              <td>
                <a href="{{ route('issues.show', $task->issue) }}">{{ $task->issue->title }}</a>
              </td>
              <td class="td-start-datetime">{!! $task->start_date_time_display !!}</td>
              <td class="td-end-datetime">{!! $task->end_date_time_display !!}</td>
              <td class="td-logged text-center">
                <i class="fa-solid fa-{{ $task->logged ? 'circle-check' : 'circle-xmark text-secondary' }}"></i>
              </td>
              <td class="td-duration text-center">{!! $task->duration_display !!}</td>
              <td class="td-min text-center">
                <div class="btn-group">
                  <a href="{{ route('tasks.edit', $task) }}" class="btn btn-link">
                    <i class="text-primary fa-regular fa-pen"></i>
                  </a>
                  <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="button" class="btn btn-link text-danger delete-task"><i class="text-danger fa-regular fa-trash"></i></button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7">
                <i class="text-secondary">No Tasks...</i>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
      {{ $tasks->links() }}
    </div>
  </div>
@endsection
