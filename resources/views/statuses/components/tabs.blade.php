<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="nav nav-tabs nav-flush" role="tablist">
          <button class="nav-link active" id="nav-status-status-options-tab" data-bs-toggle="tab" data-bs-target="#nav-status-status-options" type="button" tabindex="-1">Status Options {!! $status->status_options_count_display !!}</button>
          <button class="nav-link" id="nav-status-projects-tab" data-bs-toggle="tab" data-bs-target="#nav-status-projects" type="button" tabindex="-1">Projects {!! $status->projects_count_display !!}</button>
        </div>
      </div>
      <div class="card-body mb-0">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade active show" id="nav-status-status-options" role="tabpanel" aria-labelledby="nav-status-status-options-tab">
            <table id="nav-status-status-options-table" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center mb-0">
              <thead>
                <tr>
                  <th class="th-min text-center">ID</th>
                  <th class="th-min text-center">Label</th>
                  <th>Description</th>
                  <th>Text Color</th>
                  <th>Background Color</th>
                  <th class="th-min text-center">Initial</th>
                  <th class="th-min text-center">Completed</th>
                  <th class="th-min text-center">Previous</th>
                  <th class="th-min text-center">Next</th>
                </tr>
              </thead>
              <tbody>
                @foreach($status->statusOptions as $statusOption)
                  <tr>
                    <td class="td-min text-center">{{ $statusOption->id }}</td>
                    <td class="td-min text-center">
                      <h6 class="mb-0">{!! $statusOption->label_display !!}</h6>
                    </td>
                    <td>{!! $statusOption->description_display !!}</td>
                    <td class="td-color-display">{!! $statusOption->text_color_display !!}</td>
                    <td class="td-color-display">{!! $statusOption->background_color_display !!}</td>
                    <td  class="td-min text-center">
                      <i class="fa-solid fa-{{ $statusOption->initial_status_option ? 'circle-check' : 'circle-xmark text-secondary' }}"></i>
                    </td>
                    <td  class="td-min text-center">
                      <i class="fa-solid fa-{{ $statusOption->completed_status_option ? 'circle-check' : 'circle-xmark text-secondary' }}"></i>
                    </td>
                    <td class="td-min text-center">
                      @if($statusOption->previousStatusOption)
                        <h6 class="mb-0">{!! $statusOption->previousStatusOption->label_display !!}</h6>
                      @else
                        <i class="text-secondary">None</i>
                      @endif
                    </td>
                    <td class="td-min text-center">
                      @if($statusOption->nextStatusOption)
                        <h6 class="mb-0">{!! $statusOption->nextStatusOption->label_display !!}</h6>
                      @else
                        <i class="text-secondary">None</i>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="tab-pane fade table-responsive" id="nav-status-projects" role="tabpanel" aria-labelledby="nav-status-projects-tab">
            <table id="nav-status-projects-table" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center mb-0">
              <thead>
                <tr>
                  <th class="th-min text-center">ID</th>
                  <th>Title</th>
                  <th class="th-min text-center">Code</th>
                  <th class="th-source-code-management-url">Source Code Management (SCM) URL</th>
                  <th>Estimate</th>
                  <th>Status</th>
                  <th class="th-min text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($status->projects as $project)
                  <tr>
                    <td class="td-min text-center">{{ $project->id }}</td>
                    <td>
                      <a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a>
                    </td>
                    <td class="td-min text-center">{!! $project->code_display !!}</td>
                    <td class="td-source-code-management-url">{!! $project->source_code_management_url_display !!}</td>
                    <td>{!! $project->status_display !!}</td>
                    <td>
                      {{ $project->status->title }}
                    </td>
                    <td class="td-min">
                      <div class="btn-group">
                        <a href="{{ route('projects.edit', $project) }}" class="btn btn-link">
                          <i class="text-primary fa-regular fa-pen"></i>
                        </a>
                        <form action="{{ route('projects.destroy', $project) }}" method="POST">
                          @method('DELETE')
                          @csrf
                          <button type="button" class="btn btn-link text-danger delete-project"><i class="text-danger fa-regular fa-trash"></i></button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7">
                      <i class="text-secondary">No Connected Projects...</i>
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
