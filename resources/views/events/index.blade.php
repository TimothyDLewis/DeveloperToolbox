@extends('layouts.app')
@include('components.title', ['title' => 'Events'])

@section('body')
  @include('events.components.header')
  <div class="card mb-3">
    <div class="card-header">All Events</div>
    <div class="card-body table-responsive">
      <table id="events" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center {{ $events->hasPages() ? 'mb-3' : 'mb-0' }}">
        <thead>
          <tr>
            <th class="th-min text-center">ID</th>
            <th>Title</th>
            <th class="th-event-type text-center">Event Type</th>
            <th>Recurrence</th>
            <th class="th-affects-productivity text-center">Affects Productivity</th>
            <th class="th-estimate-options text-center">Occurences</th>
            <th class="th-min text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($events as $event)
            <tr>
              <td class="td-min text-center">{{ $event->id }}</td>
              <td>
                <a href="{{ route('events.show', $event) }}">{{ $event->title }}</a>
              </td>
              <td class="td-min text-center">
                <a href="{{ route('event-types.show', $event->eventType) }}">{!! $event->eventType->label_title_display !!}</a>
              </td>
              <td>{{ $event->recurrence_display }}</td>
              <td  class="td-affects-productivity text-center">
                <i class="fa-solid fa-{{ $event->affects_productivity ? 'circle-check' : 'circle-xmark text-secondary' }}"></i>
              </td>
              <td class="td-min text-center">{!! $event->occurences_count_display !!}</td>
              <td class="td-min text-center">
                <div class="btn-group">
                  @if($event->canEdit())
                    <a href="{{ route('events.edit', $event) }}" class="btn btn-link">
                      <i class="text-primary fa-regular fa-pen"></i>
                    </a>
                  @endif
                  <form action="{{ route('events.destroy', $event) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="button" class="btn btn-link text-danger delete-event"><i class="text-danger fa-regular fa-trash"></i></button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8">
                <i class="text-secondary">No Events...</i>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
      {{ $events->links() }}
    </div>
  </div>
@endsection
