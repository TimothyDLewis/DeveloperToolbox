<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="nav nav-tabs nav-flush" role="tablist">
          <button class="nav-link active" id="nav-issue-issues-tab" data-bs-toggle="tab" data-bs-target="#nav-issue-issues" type="button" tabindex="-1">Tasks {!! $issue->tasks_count_display !!}</button>
          <button class="nav-link" id="nav-issue-sprints-tab" data-bs-toggle="tab" data-bs-target="#nav-issue-sprints" type="button" tabindex="-1">Sprints {!! $issue->sprints_count_display !!}</button>
        </div>
      </div>
      <div class="card-body mb-0">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade active show" id="nav-issue-issues" role="tabpanel" aria-labelledby="nav-issue-issues-tab">
            <table id="nav-issue-tasks-table" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center mb-0">
              <thead>
                <tr>
                  <th class="th-min text-center">ID</th>
                  <th class="th-start-datetime text-center">Start</th>
                  <th class="th-end-datetime text-center">End</th>
                  <th class="th-logged text-center">Logged</th>
                  <th class="th-duration text-center">Duration</th>
                  <th class="th-min text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($issue->tasks as $task)
                  <tr>
                    <td class="td-min text-center">
                      <a class="id-link" href="{{ route('tasks.show', $task) }}">{{ $task->id }}</a>
                    </td>
                    <td class="td-start-datetime">{!! $task->start_date_time_display !!}</td>
                    <td class="td-end-datetime">{!! $task->end_date_time_display !!}</td>
                    <td class="td-logged text-center">
                      <i class="fa-solid fa-{{ $task->logged ? 'circle-check' : 'circle-xmark text-secondary' }}"></i>
                    </td>
                    <td class="td-duration text-center">{!! $task->duration_display !!}</td>
                    <td class="td-min text-center">
                      <div class="btn-group">
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-link">
                          <i class="text-primary fa-regular fa-pen"></i>
                        </a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                          @method('DELETE')
                          @csrf
                          <button type="button" class="btn btn-link text-danger delete-task">
                            <i class="text-danger fa-regular fa-trash"></i>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6">
                      <i class="text-secondary">No connected Tasks...</i>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <div class="tab-pane fade table-responsive" id="nav-issue-sprints" role="tabpanel" aria-labelledby="nav-issue-sprints-tab">
            <table id="nav-issue-sprints-table" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center mb-0">
              <thead>
                <tr>
                  <th class="th-min text-center">ID</th>
                  <th>Title</th>
                  <th class="th-start-date text-center">Start</th>
                  <th class="th-end-date text-center">End</th>
                  <th class="th-min text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($issue->sprints as $sprint)
                  <tr>
                    <td class="td-min text-center">{{ $sprint->id }}</td>
                    <td>
                      <a href="{{ route('sprints.show', $sprint) }}">{{ $sprint->title }}</a>
                    </td>
                    <td class="td-start-date">{!! $sprint->start_date_display !!}</td>
                    <td class="td-end-date">{!! $sprint->end_date_display !!}</td>
                    <td class="td-min">
                      <div class="btn-group">
                        <a href="{{ route('scheduler.sprint', $sprint) }}" class="btn btn-link">
                          <i class="text-success fa-regular fa-calendar"></i>
                        </a>
                        <a href="{{ route('sprints.edit', $sprint) }}" class="btn btn-link">
                          <i class="text-primary fa-regular fa-pen"></i>
                        </a>
                        <form action="{{ route('sprints.destroy', $sprint) }}" method="POST">
                          @method('DELETE')
                          @csrf
                          <button type="button" class="btn btn-link text-danger delete-sprint">
                            <i class="text-danger fa-regular fa-trash"></i>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5">
                      <i class="text-secondary">No Connected Sprints...</i>
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
