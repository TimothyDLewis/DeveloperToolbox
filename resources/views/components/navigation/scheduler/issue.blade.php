<li class="list-group-item calendar-task" data-title="{{ $issue->code . ' - ' . $issue->title }}" data-issue-id="{{ $issue->id }}" data-color="{{ $issue->statusOption->background_color }}" data-helper-class="task">
  <div class="d-flex justify-content-between mt-1 mb-2">
    {!! $issue->code_display !!}
    {!! $issue->statusOption->label_display !!}
  </div>
  <div class="fw-bold">{{ $issue->title }}</div>
</li>
