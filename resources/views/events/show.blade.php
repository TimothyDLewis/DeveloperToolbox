@extends('layouts.app')
@include('components.title', ['title' => 'Events'])

@section('body')
  @include('events.components.header', ['eventContext' => $event])
  <div class="card mb-3">
    <div class="card-header">
      View Event
    </div>
    <div class="card-body mb-0">
      <div class="row">
        <div class="col-12 mb-3">
          <label class="form-label">Title</label>
          <p class="card card-body card-condensed">{{ $event->title }}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label d-block">Event Type</label>
          <a href="{{ route('event-types.show', $event->eventType) }}">
            <h6 class="mt-3">{!! $event->eventType->label_title_display !!}</h6>
          </a>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label d-block">Affects Productivity</label>
          <i class="fa-solid fa-{{ $event->affects_productivity ? 'circle-check' : 'circle-xmark text-secondary' }} mt-2"></i>
        </div>
        <div class="{{ $event->recurrence_display_class }} mb-3">
          <label class="form-label">Recurrence</label>
          <p class="card card-body card-condensed">{{ $event->recurrence_display }}</p>
        </div>
        @if($event->yearly_eval_logic)
        <div class="{{ $event->recurrence_display_class }} mb-3">
          <label class="form-label">Yearly Eval Logic</label>
          <p class="card card-body card-condensed">
            <code class="code-text {{ $theme->themeVar('text-light', 'text-dark') }}">{{ $event->yearly_eval_logic }}</code>
          </p>
        </div>
        @endif
        @if($event->recurrence === EventRecurrence::SprintWeekly->value)
          <div class="{{ $event->recurrence_display_class }} mb-0">
            <label class="form-label">Recurrence Days</label>
            <table id="recurrenceDays" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center">
              <thead>
                <tr>
                  <th class="td-min text-center"></th>
                  <th>Recurrence Start</th>
                  <th>Recurrence End</th>
                </tr>
              </thead>
              <tbody>
                @foreach(config('constants.days') as $day)
                  @php $dayEnabled = $event->recurrence_days[$day]['enabled'] ?? false; @endphp
                  @if($dayEnabled)
                    <tr>
                      <td class="td-min text-center">{{ ucfirst($day) }}</td>
                      <td>
                        <i class="fa-solid fa-clock me-2"></i><span class="me-2">{{ Carbon::parse('2000-01-01' . $event->recurrence_days[$day]['recurrence_start_time'])->format('g:i A') }}
                      </td>
                      <td>
                        <i class="fa-solid fa-clock me-2"></i><span class="me-2">{{ Carbon::parse('2000-01-01' . $event->recurrence_days[$day]['recurrence_end_time'])->format('g:i A') }}
                      </td>
                    </tr>
                  @endif
                @endforeach
              </tbody>
            </table>
          </div>
        @elseif($event->recurrence !== EventRecurrence::NoRecurrence->value)
          <div class="{{ $event->recurrence_display_class }} mb-3">
            <label class="form-label">Recurrence Start</label>
            <p class="card card-body card-condensed d-block">{!! $event->recurrence_start_time_display !!}</p>
          </div>
          <div class="{{ $event->recurrence_display_class }} mb-3">
            <label class="form-label">Recurrence End</label><br/>
            <p class="card card-body card-condensed d-block">{!! $event->recurrence_end_time_display !!}</p>
          </div>
        @endif
        <div class="col-12 mb-3">
          <label class="form-label">Description</label>
          <p class="card card-body card-condensed">{!! nl2br($event->description_display) !!}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Created At</label>
          <p class="card card-body card-condensed d-block">{!! $event->created_at_display !!}</p>
        </div>
        <div class="col-12 col-sm-6 mb-3">
          <label class="form-label">Updated At</label>
          <p class="card card-body card-condensed d-block">{!! $event->updated_at_display !!}</p>
        </div>
      </div>
      @include('events.components.tabs', ['event' => $event])
    </div>
  </div>
@endsection
