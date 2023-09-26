<div class="fc-event-main-frame {{ $task->issue->fc_class }} {{ !$task->logged ? 'fc-unlogged' : '' }}">
  <div class="fc-event-time d-flex justify-content-center align-items-center">
    {{ $task->calendar_time_range }}
    @unless($task->logged)
      <span class="fc-log ms-2" data-task-id="{{ $task->id }}">
        <i class="fa-solid fa-check"></i>
      </span>
    @endunless
    <span class="fc-remove fc-remove-task ms-2" data-task-id="{{ $task->id }}">
      <i class="fa-solid fa-xmark"></i>
    </span>
  </div>
  <div class="fc-event-title-container">
    <div class="fc-event-title">
      <a class="fc-url" href="{{ route('issues.show', $task->issue) }}">
        <div class="d-flex justify-content-center align-items-center">
          <span class="me-2">{!! $task->issue->code_display !!}</span>
          {{ $task->issue->title }}
        </div>
      </a>
    </div>
    <hr class="fc-divider my-2" />
    <div class="mt-1 text-center d-flex justify-content-between">
      <span class="fc-status-left {{ !$task->issue->left ? 'fc-status-left-disabled' : '' }} ms-1" data-issue-id="{{ $task->issue_id }}">
        <i class="fa-solid fa-caret-left"></i>
      </span>
      <small>
        <a class="fc-status" href="{{ route('issues.edit', $task->issue) }}">{{ $task->issue->statusOption->label }}</a>
      </small>
      <span class="fc-status-right {{ !$task->issue->right ? 'fc-status-right-disabled' : '' }} me-1" data-issue-id="{{ $task->issue_id }}">
        <i class="fa-solid fa-caret-right"></i>
      </span>
    </div>
  </div>
</div>
