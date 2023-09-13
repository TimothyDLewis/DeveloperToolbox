@php $forms->setModel($sprint); @endphp
<div class="row">
  {!! $forms->renderFormField('title') !!}
  {!! $forms->renderFormField('start_date') !!}
  {!! $forms->renderFormField('end_date') !!}
  {!! $forms->renderFormField('description') !!}
</div>
{!! $forms->renderSubmitButton($sprint->exists ? 'Update Sprint' : 'Create Sprint') !!}
{!! $forms->renderCancelButton(route('sprints.index')) !!}
