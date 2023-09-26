<td class="fc-list-event-title">
  <a class="fc-url fc-url-blue d-flex align-items-center" href="{{ route('issues.show', $task->issue) }}">
    <span class="me-2">{!! $task->issue->code_display !!}</span>
    {{ $task->issue->title }}
  </a>
</td>
