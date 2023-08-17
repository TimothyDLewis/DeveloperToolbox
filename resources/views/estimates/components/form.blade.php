@php $forms->setModel($estimate); @endphp
<div class="row">
  {!! $forms->renderFormField('title') !!}
  {!! $forms->renderFormField('description') !!}
</div>
@php $forms->setModel(new EstimateOption()); @endphp
<table id="estimateOptions" class="table table-bordered {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center">
  <thead>
    <tr>
      {!! $forms->renderRepeatableFormHeader('id') !!}
      {!! $forms->renderRepeatableFormHeader('label') !!}
      {!! $forms->renderRepeatableFormHeader('value') !!}
      <th class="th-min">
        <button id="addRow" type="button" class="btn btn-link" tabindex="-1">
          <i class="text-primary fa-regular fa-plus"></i>
        </button>
      </th>
    </tr>
  </thead>
  <tbody>
    @foreach($estimateOptions as $index => $estimateOption)
      @php $forms->setModel($estimateOption); @endphp
      <tr class="estimateOption">
        <td class="td-min text-center">
          {!! $forms->renderRepeatableFormField('id', 'estimate_options', $index) !!}
          <button type="button" class="moveRowUp btn btn-link" {{ $index === 0 ? 'disabled' : '' }} tabindex="-1">
            <i class="fa-solid fa-sort-up"></i><br/>
          </button>
          <span class="estimateOptionSortOrder">{{ $index + 1 }}</span><br/>
          <button type="button" class="moveRowDown btn btn-link" {{ $index === $estimateOptions->count() - 1 ? 'disabled' : '' }} tabindex="-1">
            <i class="fa-solid fa-sort-down"></i><br/>
          </button>
        </td>
        <td>{!! $forms->renderRepeatableFormField('label', 'estimate_options', $index) !!}</td>
        <td>{!! $forms->renderRepeatableFormField('value', 'estimate_options', $index) !!}</td>
        <td class="td-min">
          <button type="button" class="removeRow btn btn-link" {{ $estimateOptions->count() === 1 ? 'disabled' : '' }} tabindex="-1">
            <i class="text-danger fa-regular fa-close"></i>
          </button>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
{!! $forms->renderSubmitButton($estimate->exists ? 'Update Estimate' : 'Create Estimate') !!}
{!! $forms->renderCancelButton(route('estimates.index')) !!}
