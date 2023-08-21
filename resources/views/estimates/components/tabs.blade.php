<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="nav nav-tabs nav-flush" role="tablist">
          <button class="nav-link active" id="nav-estimate-estimate-options-tab" data-bs-toggle="tab" data-bs-target="#nav-estimate-estimate-options" type="button" tabindex="-1">Estimate Options</button>
          <button class="nav-link" id="nav-estimate-projects-tab" data-bs-toggle="tab" data-bs-target="#nav-estimate-projects" type="button" tabindex="-1">Projects</button>
        </div>
      </div>
      <div class="card-body mb-0">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade active show" id="nav-estimate-estimate-options" role="tabpanel" aria-labelledby="nav-estimate-estimate-options-tab">
            <table id="nav-estimate-issues-table" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center mb-0">
              <thead>
                <tr>
                  <th class="th-min text-center">ID</th>
                  <th>Label</th>
                  <th>Value</th>
                </tr>
              </thead>
              <tbody>
                @foreach($estimate->estimateOptions as $estimateOption)
                  <tr>
                    <td class="td-min text-center">{{ $estimateOption->id }}</td>
                    <td>{{ $estimateOption->label }}</td>
                    <td>{{ $estimateOption->value }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="tab-pane fade table-responsive" id="nav-estimate-projects" role="tabpanel" aria-labelledby="nav-estimate-projects-tab">
            <table id="nav-estimate-projects-table" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center mb-0">
              <thead>
                <tr>
                  <th class="th-min text-center">ID</th>
                  <th>Title</th>
                  <th>Code</th>
                  <th>Source Code Management (SCM) URL
                  <th>Estimate</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($estimate->projects as $project)
                  <tr>
                    <td class="td-min text-center">{{ $project->id }}</td>
                    <td>
                      <a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a>
                    </td>
                    <td>{{ $project->code }}</td>
                    <td>{!! $project->source_code_management_url_display !!}</td>
                    <td>{{ $project->estimate->title }}</td>
                    <td>{!! $project->status_display !!}</td>
                    <td class="td-min">
                      <div class="btn-group">
                        <a href="{{ route('projects.edit', $project) }}" class="btn btn-link">
                          <i class="text-primary fa-regular fa-pen"></i>
                        </a>
                        <a href="#" class="btn btn-link">
                          <i class="text-danger fa-regular fa-trash"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6">No Connected Projects...</td>
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
