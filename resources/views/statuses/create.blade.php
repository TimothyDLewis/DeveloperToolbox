@extends('layouts.app')
@include('components.title', ['title' => 'New Status'])

@section('body')
  @include('statuses.components.header')
  <div class="card mb-3">
    <div class="card-header">New Status</div>
    <div class="card-body">
      <form id="statusForm" method="POST" action="{{ route('statuses.store') }}">
        @csrf
        @php $forms->setModel($status); @endphp
        <div class="row">
          {!! $forms->renderFormField('title') !!}
          {!! $forms->renderFormField('description') !!}
        </div>
        @php $forms->setModel(new StatusOption()); @endphp
        <table id="statusOptions" class="table table-bordered table-vertical-center {{ $theme->themeVar('table-dark', 'table-light') }}">
          <thead>
            <tr>
              {!! $forms->renderRepeatableFormHeader('id') !!}
              {!! $forms->renderRepeatableFormHeader('label') !!}
              {!! $forms->renderRepeatableFormHeader('description') !!}
              {!! $forms->renderRepeatableFormHeader('initial_status_option', 'text-center') !!}
              {!! $forms->renderRepeatableFormHeader('completed_status_option', 'text-center') !!}
              {!! $forms->renderRepeatableFormHeader('text_color') !!}
              {!! $forms->renderRepeatableFormHeader('background_color') !!}
              {!! $forms->renderRepeatableFormHeader('previous_status') !!}
              {!! $forms->renderRepeatableFormHeader('next_status') !!}
              <th class="th-min">
                <button id="addRow" type="button" class="btn btn-link" tabindex="-1">
                  <i class="text-primary fa-regular fa-plus"></i>
                </button>
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach($statusOptions as $index => $statusOption)
              @php
                $forms->setModel($statusOption);
                $relatedStatusOptions = $statusOptions->reject(function ($_statusOption, $soIndex) use ($index) {
                  return $soIndex === $index;
                })->map(function ($statusOption, $index) {
                  return (object)[
                    'id' => $index,
                    'label' => $statusOption->label ?? "Status Option #" . ($index + 1)
                  ];
                });
              @endphp
              <tr class="statusOption">
                <td class="td-min text-center">
                  {!! $forms->renderRepeatableFormField('id', 'status_options', $index) !!}
                  <button type="button" class="moveRowUp btn btn-link" {{ $index === 0 ? 'disabled' : '' }} tabindex="-1">
                    <i class="fa-solid fa-sort-up"></i><br/>
                  </button>
                  <span class="statusOptionSortOrder">{{ $index + 1 }}</span><br/>
                  <button type="button" class="moveRowDown btn btn-link" {{ $index === $statusOptions->count() - 1 ? 'disabled' : '' }} tabindex="-1">
                    <i class="fa-solid fa-sort-down"></i><br/>
                  </button>
                </td>
                <td>{!! $forms->renderRepeatableFormField('label', 'status_options', $index, ['placeholder' => "Status Option #" . ($index + 1)]) !!}</td>
                <td>{!! $forms->renderRepeatableFormField('description', 'status_options', $index) !!}</td>
                <td class="td-boolean text-center">{!! $forms->renderRepeatableFormField('initial_status_option', 'status_options', $index, ['default' => 0, 'inputClass' => 'initialStatusOption']) !!}</td>
                <td class="td-boolean text-center">{!! $forms->renderRepeatableFormField('completed_status_option', 'status_options', $index, ['default' => 0]) !!}</td>
                <td class="td-color">{!! $forms->renderRepeatableFormField('text_color', 'status_options', $index, ['default' => $theme->themeVar('#f8f9fa', '#212529')]) !!}</td>
                <td class="td-color">{!! $forms->renderRepeatableFormField('background_color', 'status_options', $index, ['default' => $theme->themeVar('#212529', '#f8f9fa')]) !!}</td>
                <td class="td-select">{!! $forms->renderRepeatableFormField('previous_status', 'status_options', $index, ['options' => $relatedStatusOptions]) !!}</td>
                <td class="td-select">{!! $forms->renderRepeatableFormField('next_status', 'status_options', $index, ['options' => $relatedStatusOptions]) !!}</td>
                <td class="td-min">
                  <button type="button" class="removeRow btn btn-link" {{ $statusOptions->count() === 1 ? 'disabled' : '' }} tabindex="-1">
                    <i class="text-danger fa-regular fa-close"></i>
                  </button>
                </td>
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
