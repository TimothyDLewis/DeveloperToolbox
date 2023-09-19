@extends('layouts.app')
@include('components.title', ['title' => 'Projects'])

@section('body')
  @include('projects.components.header')
  <div class="card mb-3">
    <div class="card-header">All Projects</div>
    <div class="card-body table-responsive">
      <table id="projects" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center {{ $projects->hasPages() ? 'mb-3' : 'mb-0' }}">
        <thead>
          <tr>
            <th class="th-min text-center">ID</th>
            <th class="th-min text-center">Code</th>
            <th>Title</th>
            <th class="th-source-code-management-url">Source Code Management (SCM) URL</th>
            <th>Estimate</th>
            <th>Status</th>
            <th class="th-min text-center">Issues</th>
            <th class="th-min text-center">Resources</th>
            <th class="th-min text-center">Actions</th>
            <th class="th-touched text-center text-secondary">
              <i class="fa-solid fa-clock-rotate-left fa-flip-horizontal"></i>
            </th>
          </tr>
        </thead>
        <tbody>
          @forelse($projects as $project)
            <tr>
              <td class="td-min text-center">{{ $project->id }}</td>
              <td class="td-min text-center">{!! $project->code_display !!}</td>
              <td>
                <a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a>
              </td>
              <td class="td-source-code-management-url">{!! $project->source_code_management_url_display !!}</td>
              <td>{!! $project->estimate_display !!}</td>
              <td>{!! $project->status_display !!}</td>
              <td class="td-min text-center">{!! $project->issues_count_display !!}</td>
              <td class="td-min text-center">{!! $project->resources_count_display !!}</td>
              <td class="td-min">
                <div class="btn-group">
                  <a href="{{ route('projects.edit', $project) }}" class="btn btn-link">
                    <i class="text-primary fa-regular fa-pen"></i>
                  </a>
                  <form action="{{ route('projects.destroy', $project) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="button" class="btn btn-link text-danger delete-project">
                      <i class="text-danger fa-regular fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
              <td class="td-touched text-center">
                {!! $project->touched_display !!}
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="10">
                <i class="text-secondary">No Projects...</i>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
      {{ $projects->links() }}
    </div>
  </div>
@endsection
