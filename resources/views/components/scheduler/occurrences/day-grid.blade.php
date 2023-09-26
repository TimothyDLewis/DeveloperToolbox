@if(!$occurrence->all_day)
  <div class="fc-daygrid-event-dot" style="border-color: {{ $occurrence->event->eventType->background_color }};"></div>
  <div class="fc-event-time {{ $theme->themeVar('text-light', 'text-dark') }}">{{ $occurrence->formatted_start_time }}</div>
@endif
<div class="fc-event-title">
  <a class="fc-url {{ $occurrence->all_day ? '' : $theme->themeVar('text-light', 'text-dark') }}" href="{{ route('events.show', $occurrence->event) }}">{{ $occurrence->event->title }}</a>
</div>
