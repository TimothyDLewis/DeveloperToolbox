<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="nav nav-tabs nav-flush" role="tablist">
          <button class="nav-link active" id="nav-project-issues-tab" data-bs-toggle="tab" data-bs-target="#nav-project-issues" type="button" tabindex="-1">Issues</button>
          <button class="nav-link" id="nav-project-resources-tab" data-bs-toggle="tab" data-bs-target="#nav-project-resources" type="button" tabindex="-1">Resources</button>
        </div>
      </div>
      <div class="card-body mb-0">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade active show" id="nav-project-issues" role="tabpanel" aria-labelledby="nav-project-issues-tab">
            <table id="nav-project-issues-table" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center mb-0">
              <thead>
                <tr>
                  <th class="th-min text-center">ID</th>
                </tr>
              </thead>
              <tbody>
                @forelse($project->issues as $issue)
                @empty
                <tr>
                  <td colspan="1">No Connected Issues...</td>
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
                  <td colspan="7">No connected Resources...</td>
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
