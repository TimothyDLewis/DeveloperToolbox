<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="nav nav-tabs nav-flush" role="tablist">
          <button class="nav-link active" id="nav-sprint-issues-tab" data-bs-toggle="tab" data-bs-target="#nav-sprint-issues" type="button" tabindex="-1">Issues {!! $sprint->issues_count_display !!}</button>
        </div>
      </div>
      <div class="card-body mb-0">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade active show" id="nav-sprint-issues" role="tabpanel" aria-labelledby="nav-sprint-issues-tab">
            <table id="nav-sprint-issues-table" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center mb-0">
              <thead>
                <tr>
                  <th class="th-min text-center">ID</th>
                  <th>Title</th>
                  <th class="th-min text-center">Code</th>
                  <th class="th-external-url">External URL</th>
                  <th>Project</th>
                  <th class="th-estimate-option text-center">Estimate Option</th>
                  <th class="th-status-option text-center">Status Option</th>
                  <th class="th-min text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($sprint->issues as $issue)
                  <tr>
                    <td class="td-min text-center">{{ $issue->id }}</td>
                    <td>
                      <a href="{{ route('issues.show', $issue) }}">{{ $issue->title }}</a>
                    </td>
                    <td class="td-min text-center">{{ $issue->code }}</td>
                    <td class="td-external-url">{!! $issue->external_url_display !!}</td>
                    <td>
                      <i class="text-secondary">{{ $issue->sprint->title }}</i>
                    </td>
                    <td class="td-estimate-option text-center">{!! $issue->estimateOption->label_display_alt !!}</td>
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
                    <td colspan="8">
                      <i class="text-secondary">No Connected Issues...</i>
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
