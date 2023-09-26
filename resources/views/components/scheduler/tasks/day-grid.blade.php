<div class="fc-daygrid-event-dot" style="border-color: {{ $task->issue->statusOption->background_color }};"></div>
<div class="fc-event-time {{ $theme->themeVar('text-light', 'text-dark') }}">
  {{ $task->formatted_start_time }}
</div>
<div class="fc-event-title">
  <a class="fc-url {{ $theme->themeVar('text-light', 'text-dark') }}" href="{{ route('issues.show', $task->issue) }}">
    <span class="d-block d-sm-block d-md-block d-lg-block d-xl-none">{!! $task->issue->code_display !!}</span>
    <span class="d-none d-sm-none d-md-none d-lg-none d-xl-block">{{ $task->issue->title }}</span>
  </a>
</div>
