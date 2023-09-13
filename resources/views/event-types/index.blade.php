@extends('layouts.app')
@include('components.title', ['title' => 'Event Types'])

@section('body')
  @include('event-types.components.header')
  <div class="card mb-3">
    <div class="card-header">All Event Types</div>
    <div class="card-body table-responsive">
      <table id="eventTypes" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center {{ $eventTypes->hasPages() ? 'mb-3' : 'mb-0' }}">
        <thead>
          <tr>
            <th class="th-min text-center">ID</th>
            <th class="th-min text-center">Title</th>
            <th>Description</th>
            <th>Text Color</th>
            <th>Background Color</th>
            <th class="th-affects-productivity text-center">Affects Productivity</th>
            <th class="th-min text-center">Events</th>
            <th class="th-min text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($eventTypes as $eventType)
            <tr>
              <td class="td-min text-center">{{ $eventType->id }}</td>
              <td class="td-min text-center">
                <a href="{{ route('event-types.show', $eventType) }}">{!! $eventType->label_title_display !!}</a>
              </td>
              <td>{!! $eventType->description_display !!}</td>
              <td class="td-color-display">{!! $eventType->text_color_display !!}</td>
              <td class="td-color-display">{!! $eventType->background_color_display !!}</td>
              <td  class="td-affects-productivity text-center">
                <i class="fa-solid fa-{{ $eventType->affects_productivity ? 'circle-check' : 'circle-xmark text-secondary' }}"></i>
              </td>
              <td class="td-min text-center">{!! $eventType->events_count_display !!}</td>
              <td class="td-min">
                <div class="btn-group">
                  <a href="{{ route('event-types.edit', $eventType) }}" class="btn btn-link">
                    <i class="text-primary fa-regular fa-pen"></i>
                  </a>
                  <form action="{{ route('event-types.destroy', $eventType) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="button" class="btn btn-link text-danger delete-event-type"><i class="text-danger fa-regular fa-trash"></i></button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8">
                <i class="text-secondary">No Event Types...</i>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
      {{ $eventTypes->links() }}
    </div>
  </div>
@endsection
