@extends('layouts.app')
@include('components.title', ['title' => 'Occurences'])

@section('body')
  @include('occurences.components.header')
  <div class="card mb-3">
    <div class="card-header">All Occurences</div>
    <div class="card-body table-responsive">
      <table id="occurences" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center {{ $occurences->hasPages() ? 'mb-3' : 'mb-0' }}">
        <thead>
          <tr>
            <th class="th-min text-center">ID</th>
            <th class="th-min">Sprint</th>
            <th>Event</th>
            <th class="th-event-type text-center">Event Type</th>
            <th class="th-all-day text-center">All Day</th>
            <th class="th-start-datetime text-center">Start</th>
            <th class="th-end-datetime text-center">End</th>
            <th class="th-duration text-center">Duration</th>
            <th class="th-min text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($occurences as $occurence)
            <tr>
              <td class="td-min text-center">
                <a class="id-link" href="{{ route('occurences.show', $occurence) }}">{{ $occurence->id }}</a>
              </td>
              <td>
                <i class="text-secondary">None</i>
              </td>
              <td>
                <a href="{{ route('events.show', $occurence->event) }}">{{ $occurence->event->title }}</a>
              </td>
              <td class="td-event-type text-center">
                <a href="{{ route('event-types.show', $occurence->event->eventType) }}">{!! $occurence->event->eventType->label_title_display !!}</a>
              </td>
              <td class="td-all-day text-center">
                <i class="fa-solid fa-{{ $occurence->all_day ? 'circle-check' : 'circle-xmark text-secondary' }}"></i>
              </td>
              @if($occurence->all_day)
                <td class="td-all-day-datetime" colspan="2">{!! $occurence->start_date_time_as_date_display !!}</td>
              @else
                <td class="td-start-datetime">{!! $occurence->start_date_time_display !!}</td>
                <td class="td-end-datetime">{!! $occurence->end_date_time_display !!}</td>
              @endif
              <td class="td-duration text-center">{!! $occurence->duration_display !!}</td>
              <td class="td-min text-center">
                <div class="btn-group">
                  <a href="{{ route('occurences.edit', $occurence) }}" class="btn btn-link">
                    <i class="text-primary fa-regular fa-pen"></i>
                  </a>
                  <form action="{{ route('occurences.destroy', $occurence) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="button" class="btn btn-link text-danger delete-occurence"><i class="text-danger fa-regular fa-trash"></i></button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9">
                <i class="text-secondary">No Occurences...</i>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
      {{ $occurences->links() }}
    </div>
  </div>
@endsection
