@extends('layouts.app')
@include('components.title', ['title' => 'Resources'])

@section('body')
  @include('resources.components.header')
  <div class="card mb-3">
    <div class="card-header">All Resources</div>
    <div class="card-body table-responsive">
      <table id="resources" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center {{ $resources->hasPages() ? 'mb-3' : 'mb-0' }}">
        <thead>
          <tr>
            <th class="th-min text-center"></th>
            <th class="th-min text-center">ID</th>
            <th class="th-min text-center">Label</th>
            <th>Title</th>
            <th>Description</th>
            <th>Text Color</th>
            <th>Background Color</th>
            <th colspan="2">Project</th>
            <th class="th-min text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($resources as $resource)
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
              @if($resource->project)
                <td class="td-min text-center">{!! $resource->project->code_display !!}</td>
              @endif
              <td colspan="{{ $resource->project ? 1 : 2 }}">{!! $resource->project_display !!}</td>
              <td class="td-min">
                <div class="btn-group">
                  <a href="{{ route('resources.edit', $resource) }}" class="btn btn-link">
                    <i class="text-primary fa-regular fa-pen"></i>
                  </a>
                  <form action="{{ route('resources.destroy', $resource) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="button" class="btn btn-link text-danger delete-resource">
                      <i class="text-danger fa-regular fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="10">
                <i class="text-secondary">No Resources...</i>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
      {{ $resources->links() }}
    </div>
  </div>
@endsection
