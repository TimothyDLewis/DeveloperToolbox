<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="nav nav-tabs nav-flush" role="tablist">
          <button class="nav-link active" id="nav-issue-issues-tab" data-bs-toggle="tab" data-bs-target="#nav-issue-issues" type="button" tabindex="-1">Tasks ({{ $issue->tasks->count() }})</button>
        </div>
      </div>
      <div class="card-body mb-0">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade active show" id="nav-issue-issues" role="tabpanel" aria-labelledby="nav-issue-issues-tab">
            <table id="nav-issue-tasks-table" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center mb-0">
              <thead>
                <tr>
                  <th class="th-min text-center">ID</th>
                  <th class="th-min text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($issue->tasks as $task)
                  <tr>
                    <td class="td-min text-center">{{ $task->id }}</td>
                    <td class="td-min text-center">
                      <a href="{{ route('tasks.edit', $task) }}" class="btn btn-link">
                        <i class="text-primary fa-regular fa-pen"></i>
                      </a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="2">
                      <i class="text-secondary">No connected Tasks...</i>
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
