@extends('layouts.app')
@include('components.title', ['title' => 'Projects'])

@section('body')
  @include('projects.components.header')
  <div class="card mb-3">
    <div class="card-header">All Projects</div>
    <div class="card-body">
      <table id="projects" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center mb-0">
        <thead>
          <tr>
            <th class="th-min text-center">ID</th>
            <th>Title</th>
            <th class="th-min text-center">Code</th>
            <th>Source Code Management (SCM) URL</th>
            <th>Estimate</th>
            <th>Status</th>
            <th>Issues</th>
            <th>Resources</th>
            <th class="th-min text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($projects as $project)
            <tr>
              <td class="td-min text-center">{{ $project->id }}</td>
              <td>
                <a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a>
              </td>
              <td class="td-min text-center">{{ $project->code }}</td>
              <td class="td-url">{!! $project->source_code_management_url_display !!}</td>
              <td>{!! $project->estimate_display !!}</td>
              <td>{!! $project->status_display !!}</td>
              <td>{{ $project->issues_count }}</td>
              <td>{{ $project->resources_count }}</td>
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
              <td colspan="9">No Projects...</td>
            </tr>
          @endforelse
        </tbody>
      </table>
      {{ $projects->links() }}
    </div>
  </div>
@endsection
