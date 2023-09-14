<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="nav nav-tabs nav-flush" role="tablist">
          <button class="nav-link active" id="nav-project-issues-tab" data-bs-toggle="tab" data-bs-target="#nav-project-issues" type="button" tabindex="-1">Issues {!! $project->issues_count_display !!}</button>
          <button class="nav-link" id="nav-project-resources-tab" data-bs-toggle="tab" data-bs-target="#nav-project-resources" type="button" tabindex="-1">Resources {!! $project->resources_count_display !!}</button>
        </div>
      </div>
      <div class="card-body mb-0">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade active show" id="nav-project-issues" role="tabpanel" aria-labelledby="nav-project-issues-tab">
            <table id="nav-project-issues-table" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center mb-0">
              <thead>
                <tr>
                  <th class="th-min text-center">ID</th>
                  <th class="th-min text-center">Code</th>
                  <th>Title</th>
                  <th class="th-external-url">External URL</th>
                  <th class="th-estimate-option text-center">Estimate Option</th>
                  <th class="th-status-option text-center">Status Option</th>
                  <th class="th-min text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($project->issues as $issue)
                  <tr>
                    <td class="td-min text-center">{{ $issue->id }}</td>
                    <td class="td-min text-center">{!! $issue->code_display !!}</td>
                    <td>
                      <a href="{{ route('issues.show', $issue) }}">{{ $issue->title }}</a>
                    </td>
                    <td class="td-external-url">{!! $issue->external_url_display !!}</td>
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
          <div class="tab-pane fade table-responsive" id="nav-project-resources" role="tabpanel" aria-labelledby="nav-project-resources-tab">
            <table id="nav-project-resources-table" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center mb-0">
              <thead>
                <tr>
                  <th class="th-min text-center"></th>
                  <th class="th-min text-center">ID</th>
                  <th class="th-min text-center">Label</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Text Color</th>
                  <th>Background Color</th>
                  <th class="th-min text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($project->resources as $resource)
                  <tr>
                    <td class="td-min text-center">{!! $resource->bookmarked_display !!}</td>
                    <td class="td-min text-center">{{ $resource->id }}</td>
                    <td class="td-min text-center">
                      <h6 class="mb-0">{!! $resource->label_display !!}</h6>
                    </td>
                    <td class="td-url">{!! $resource->url_title_display !!}</td>
                    <td>{!! $resource->description_display !!}</td>
                    <td class="td-color-display">{!! $resource->text_color_display !!}</td>
                    <td class="td-color-display">{!! $resource->background_color_display !!}</td>
                    <td class="td-min text-center">
                      <a href="{{ route('resources.edit', $resource) }}" class="btn btn-link">
                        <i class="text-primary fa-regular fa-pen"></i>
                      </a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="8">
                      <i class="text-secondary">No connected Resources...</i>
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
