@extends('layouts.app')
@include('components.title', ['title' => 'Estimates'])

@section('body')
  @include('estimates.components.header')
  <div class="card mb-3">
    <div class="card-header">All Estimates</div>
    <div class="card-body">
      <table id="estimates" class="table table-bordered table-striped {{ $theme->themeClass('table-dark', 'table-light') }} table-vertical-center mb-0">
        <thead>
          <tr>
            <th class="th-min text-center">ID</th>
            <th>Title</th>
            <th>Estimate Options</th>
            <th>Projects</th>
            <th class="th-min text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($estimates as $estimate)
            <tr>
              <td class="td-min text-center">{{ $estimate->id }}</td>
              <td>
                <a href="{{ route('estimates.show', $estimate) }}">{{ $estimate->title }}</a>
              </td>
              <td>{{ $estimate->estimate_options_count }}</td>
              <td>{{ $estimate->projects_count }}</td>
              <td class="td-min">
                <div class="btn-group">
                  <a href="{{ route('estimates.edit', $estimate) }}" class="btn btn-link">
                    <i class="text-primary fa-regular fa-pen"></i>
                  </a>
                  <form action="{{ route('estimates.destroy', $estimate) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="button" class="btn btn-link text-danger delete-estimate"><i class="text-danger fa-regular fa-trash"></i></button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5">No Estimates...</td>
            </tr>
          @endforelse
        </tbody>
      </table>
      {{ $estimates->links() }}
    </div>
  </div>
@endsection
