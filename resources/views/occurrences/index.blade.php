@extends('layouts.app')
@include('components.title', ['title' => 'Occurrences'])

@section('body')
  @include('occurrences.components.header')
  <div class="card mb-3">
    <div class="card-header">All Occurrences</div>
    <div class="card-body table-responsive">
      <table id="occurrences" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center {{ $occurrences->hasPages() ? 'mb-3' : 'mb-0' }}">
        <thead>
          <tr>
            <th class="th-min text-center">ID</th>
            <th>Event</th>
            <th>Sprint</th>
            <th class="th-event-type text-center">Event Type</th>
            <th class="th-all-day text-center">All Day</th>
            <th class="th-start-datetime text-center">Start</th>
            <th class="th-end-datetime text-center">End</th>
            <th class="th-duration text-center">Duration</th>
            <th class="th-min text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($occurrences as $occurrence)
            <tr>
              <td class="td-min text-center">
                <a class="id-link" href="{{ route('occurrences.show', $occurrence) }}">{{ $occurrence->id }}</a>
              </td>
              <td>
                <a href="{{ route('events.show', $occurrence->event) }}">{{ $occurrence->event->title }}</a>
              </td>
              <td>
                @if($occurrence->sprint)
                  <a href="{{ route('sprints.show', $occurrence->sprint) }}">{{ $occurrence->sprint->title }}</a>
                @else
                  <i class="text-secondary">None</i>
                @endif
              </td>
              <td class="td-event-type text-center">
                <a href="{{ route('event-types.show', $occurrence->event->eventType) }}">{!! $occurrence->event->eventType->label_title_display !!}</a>
              </td>
              <td class="td-all-day text-center">
                <i class="fa-solid fa-{{ $occurrence->all_day ? 'circle-check' : 'circle-xmark text-secondary' }}"></i>
              </td>
              @if($occurrence->all_day)
                <td class="td-all-day-datetime" colspan="2">{!! $occurrence->start_date_time_as_date_display !!}</td>
              @else
                <td class="td-start-datetime">{!! $occurrence->start_date_time_display !!}</td>
                <td class="td-end-datetime">{!! $occurrence->end_date_time_display !!}</td>
              @endif
              <td class="td-duration text-center">{!! $occurrence->duration_display !!}</td>
              <td class="td-min text-center">
                <div class="btn-group">
                  <a href="{{ route('occurrences.edit', $occurrence) }}" class="btn btn-link">
                    <i class="text-primary fa-regular fa-pen"></i>
                  </a>
                  <form action="{{ route('occurrences.destroy', $occurrence) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="button" class="btn btn-link text-danger delete-occurrence"><i class="text-danger fa-regular fa-trash"></i></button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9">
                <i class="text-secondary">No Occurrences...</i>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
      {{ $occurrences->links() }}
    </div>
  </div>
@endsection
