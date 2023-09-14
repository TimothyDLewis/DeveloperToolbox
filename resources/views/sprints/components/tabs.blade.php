<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="nav nav-tabs nav-flush" role="tablist">
          <button class="nav-link active" id="nav-sprint-issues-tab" data-bs-toggle="tab" data-bs-target="#nav-sprint-issues" type="button" tabindex="-1">Issues {!! $sprint->issues_count_display !!}</button>
          <button class="nav-link" id="nav-sprint-occurrences-tab" data-bs-toggle="tab" data-bs-target="#nav-sprint-occurrences" type="button" tabindex="-1">Occurrences {!! $sprint->occurrences_count_display !!}</button>
        </div>
      </div>
      <div class="card-body mb-0">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade active show" id="nav-sprint-issues" role="tabpanel" aria-labelledby="nav-sprint-issues-tab">
            <table id="nav-sprint-issues-table" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center mb-0">
              <thead>
                <tr>
                  <th class="th-min text-center">ID</th>
                  <th class="th-min text-center">Code</th>
                  <th>Title</th>
                  <th>Project</th>
                  <th class="th-external-url">External URL</th>
                  <th colspan="2" class="th-estimate-option text-center">Estimate Option</th>
                  <th class="th-status-option text-center">Status Option</th>
                  <th class="th-min text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($sprint->issues as $issue)
                  <tr>
                    <td class="td-min text-center">{{ $issue->id }}</td>
                    <td class="td-min text-center">{!! $issue->code_display !!}</td>
                    <td>
                      <a href="{{ route('issues.show', $issue) }}">{{ $issue->title }}</a>
                    </td>
                    <td>{!! $issue->project_display !!}</td>
                    <td class="td-external-url">{!! $issue->external_url_display !!}</td>
                    <td class="td-estimate-option text-center">{!! $issue->estimateOption->label_display_alt !!}</td>
                    <td class="td-estimate-option text-center">{!! $issue->estimateOption->value_display !!}</td>
                    <td class="td-status-option text-center">{!! $issue->statusOption->label_display !!}</td>
                    <td class="td-min">
                      <div class="btn-group">
                        <a href="{{ route('issues.edit', $issue) }}" class="btn btn-link">
                          <i class="text-primary fa-regular fa-pen"></i>
                        </a>
                        <form action="{{ route('issues.destroy', $issue) }}" method="POST">
                          @method('DELETE')
                          @csrf
                          <button type="button" class="btn btn-link text-danger delete-issue"><i class="text-danger fa-regular fa-trash"></i></button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="9">
                      <i class="text-secondary">No Connected Issues...</i>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <div class="tab-pane fade show" id="nav-sprint-occurrences" role="tabpanel" aria-labelledby="nav-sprint-occurrences-tab">
            <table id="nav-sprint-occurrences-table" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center mb-0">
              <thead>
                <tr>
                  <th class="th-min text-center">ID</th>
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
                @forelse($sprint->occurrences as $occurrence)
                  <tr>
                    <td class="td-min text-center">
                      <a class="id-link" href="{{ route('occurrences.show', $occurrence) }}">{{ $occurrence->id }}</a>
                    </td>
                    <td>
                      <a href="{{ route('events.show', $occurrence->event) }}">{{ $occurrence->event->title }}</a>
                    </td>
                    <td class="td-event-type text-center">
                      <a href="{{ route('event-types.show', $occurrence->event->eventType) }}">{!! $occurrence->event->eventType->label_title_display !!}</a>
                    </td>
                    <td class="td-all-day text-center">
                      <i class="fa-solid fa-{{ $occurrence->all_day ? 'circle-check' : 'circle-xmark text-secondary' }}"></i>
                    </td>
                    @if($occurrence->all_day)
                      <td class="td-all-day-datetime" colspan="2">{!! $occurrence->start_date_time_as_date_display !!}</td>
                    @else
                      <td class="td-start-datetime">{!! $occurrence->start_date_time_display !!}</td>
                      <td class="td-end-datetime">{!! $occurrence->end_date_time_display !!}</td>
                    @endif
                    <td class="td-duration text-center">{!! $occurrence->duration_display !!}</td>
                    <td class="td-min text-center">
                      <div class="btn-group">
                        <a href="{{ route('occurrences.edit', $occurrence) }}" class="btn btn-link">
                          <i class="text-primary fa-regular fa-pen"></i>
                        </a>
                        <form action="{{ route('occurrences.destroy', $occurrence) }}" method="POST">
                          @method('DELETE')
                          @csrf
                          <button type="button" class="btn btn-link text-danger delete-occurrence"><i class="text-danger fa-regular fa-trash"></i></button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="9">
                      <i class="text-secondary">No Connected Occurrences...</i>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
