<div id="scheduler-sidebar" class="d-flex flex-column flex-shrink-0 p-2 bg-body-tertiary">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="mb-2">
            <label class="form-label">Occurence Duration</label>
            <select id="timeblockDuration" class="form-control">
              @foreach(config('constants.durations') as $minutes => $duration)
                <option value="{{ $minutes }}" @selected($minutes === 15) data-duration="{{ $duration['duration'] }}">{{ $duration['label'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="nav nav-tabs nav-justified nav-flush" role="tablist">
            <button class="nav-link active" id="navSchedulerIssuesTab" data-bs-toggle="tab" data-bs-target="#navSchedulerIssues" type="button" tabindex="-1">Issues</button>
            <button class="nav-link" id="navSchedulerEventsTab" data-bs-toggle="tab" data-bs-target="#navSchedulerEvents" type="button" tabindex="-1">Events</button>
          </div>
        </div>
        <div class="card-body mb-0">
          <div class="tab-content">
            <div id="navSchedulerIssues" class="tab-pane fade active show">
              <ul class="list-group">
                @forelse($issues as $issue)
                  <li class="list-group-item calendar-task" data-title="{{ $issue->code . ' - ' . $issue->title }}" data-issue-id="{{ $issue->id }}" data-color="{{ $issue->statusOption->background_color }}" data-helper-class="task">
                    <div class="d-flex justify-content-between mt-1 mb-2">
                      {!! $issue->code_display !!}
                      {!! $issue->statusOption->label_display !!}
                    </div>
                    <div class="fw-bold">{{ $issue->title }}</div>
                  </li>
                @empty
                  <li class="list-group-item">
                    <h6 class="text-secondary mt-2">No Issues...</h6>
                  </li>
                @endforelse
              </ul>
            </div>
            <div id="navSchedulerEvents" class="tab-pane fade">
              @if($eventTypes->isEmpty())
                <ul class="list-group">
                  <li class="list-group-item">
                    <h6 class="text-secondary mt-2">No Events...</h6>
                  </li>
                </ul>
              @else
                <div id="navSchedulerEventsCard" class="card">
                  @foreach($eventTypes as $eventType)
                    <div class="card-header toggle-dropdown" data-bs-toggle="collapse" href="#navSchedulerEventType{{ $eventType->slug }}">
                      <div class="d-flex align-items-center justify-content-between">
                        {!! $eventType->label_title_events_count_display !!}
                        <i class="toggle-icon fa-solid fa-angle-right ms-3"></i>
                      </div>
                    </div>
                    <ul id="navSchedulerEventType{{ $eventType->slug }}" class="list-group list-group-flush collapse">
                      @foreach($eventType->events as $event)
                        <li class="list-group-item calendar-occurrence" data-title="{{ $event->title }}" data-event-id="{{ $event->id }}" data-color="{{ $event->eventType->background_color }}" data-helper-class="occurrence">
                          <small>
                            @if($event->recurrence != EventRecurrence::NoRecurrence->value)
                              <i class="fa-solid fa-rotate"></i>
                            @endif
                            {{ $event->title }}
                          </small>
                        </li>
                      @endforeach
                    </ul>
                  @endforeach
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="vertical-divider vertical-vr"></div>
