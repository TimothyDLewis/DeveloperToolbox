@extends('layouts.app')
@include('components.title', ['title' => 'Edit Status'])

@section('body')
  @include('statuses.components.header', ['statusContext' => $status])
  <div class="card mb-3">
    <div class="card-header">Edit Status</div>
    <div class="card-body">
      <form id="statusForm" method="POST" action="{{ route('statuses.update', $status) }}">
        @csrf
        @method('PATCH')
        @php $forms->setModel($status); @endphp
        <div class="row">
          {!! $forms->renderFormField('title') !!}
          {!! $forms->renderFormField('description') !!}
        </div>
        @php $forms->setModel($statusOptions->first()); @endphp
        <table id="statusOptions" class="table table-bordered {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center">
          <thead>
            <tr>
              {!! $forms->renderRepeatableFormHeader('id') !!}
              {!! $forms->renderRepeatableFormHeader('label') !!}
              {!! $forms->renderRepeatableFormHeader('description') !!}
              {!! $forms->renderRepeatableFormHeader('initial_status_option', 'text-center') !!}
              {!! $forms->renderRepeatableFormHeader('text_color') !!}
              {!! $forms->renderRepeatableFormHeader('background_color') !!}
            </tr>
          </thead>
          <tbody>
            @foreach($statusOptions as $index => $statusOption)
              @php $forms->setModel($statusOption); @endphp
              <tr class="statusOption">
                <td class="td-min text-center">
                  {!! $forms->renderRepeatableFormField('id', 'status_options', $index) !!}
                  <span class="statusOptionSortOrder">{{ $index + 1 }}</span><br/>
                </td>
                <td>{!! $forms->renderRepeatableFormField('label', 'status_options', $index, ['placeholder' => "Status Option #" . ($index + 1)]) !!}</td>
                <td>{!! $forms->renderRepeatableFormField('description', 'status_options', $index) !!}</td>
                <td class="td-boolean text-center">{!! $forms->renderRepeatableFormField('initial_status_option', 'status_options', $index) !!}</td>
                <td class="td-color">{!! $forms->renderRepeatableFormField('text_color', 'status_options', $index, ['default' => $theme->themeVar('#f8f9fa', '#212529')]) !!}</td>
                <td class="td-color">{!! $forms->renderRepeatableFormField('background_color', 'status_options', $index, ['default' => $theme->themeVar('#212529', '#f8f9fa')]) !!}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
        {!! $forms->renderSubmitButton($status->exists ? 'Update Status' : 'Create Status') !!}
        {!! $forms->renderCancelButton(route('statuses.index')) !!}
      </form>
    </div>
  </div>
@endsection
