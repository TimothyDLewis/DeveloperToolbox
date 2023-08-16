@php $forms->setModel($status); @endphp
<div class="row">
  {!! $forms->renderFormField('title') !!}
  {!! $forms->renderFormField('description') !!}
</div>
<div class="row">
  <div class="col-12">
    <table id="statusOptions" class="table table-bordered {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center">
      <thead>
        <tr>
          <th colspan="7">Status Options</th>
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
            <td>{!! $forms->renderRepeatableFormField('label', 'status_options', $index) !!}</td>
            <td>{!! $forms->renderRepeatableFormField('description', 'status_options', $index) !!}</td>
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
  </div>
</div>
{!! $forms->renderSubmitButton($status->exists ? 'Update Status' : 'Create Status') !!}
{!! $forms->renderCancelButton(route('statuses.index')) !!}
