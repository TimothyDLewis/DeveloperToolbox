@extends('layouts.app')
@include('components.title', ['title' => 'Issues'])

@section('body')
  @include('issues.components.header')
  <div class="card mb-3">
    <div class="card-header">All Issues</div>
    <div class="card-body table-responsive">
      <table id="issues" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center {{ $issues->hasPages() ? 'mb-3' : 'mb-0' }}">
        <thead>
          <tr>
            <th class="th-min text-center">ID</th>
            <th>Title</th>
            <th class="th-min text-center">Code</th>
            <th class="th-external-url">External URL</th>
            <th>Project</th>
            <th class="th-estimate-option text-center">Estimate Option</th>
            <th class="th-estimate-option text-center">Status Option</th>
            <th>Tasks</th>
            <th class="th-min text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($issues as $issue)
            <tr>
              <td class="td-min text-center">{{ $issue->id }}</td>
              <td>
                <a href="{{ route('issues.show', $issue) }}">{{ $issue->title }}</a>
              </td>
              <td class="td-min text-center">{{ $issue->code }}</td>
              <td class="td-external-url">{!! $issue->external_url_display !!}</td>
              <td>{!! $issue->project_display !!}</td>
              <td class="td-estimate-option text-center">{!! $issue->estimateOption->label_display_alt !!}</td>
              <td class="td-status-option text-center">{!! $issue->statusOption->label_display !!}</td>
              <td>{{ $issue->tasks_count }}</td>
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
              <td colspan="9">
                <i class="text-secondary">No Issues...</i>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
      {{ $issues->links() }}
    </div>
  </div>
@endsection
