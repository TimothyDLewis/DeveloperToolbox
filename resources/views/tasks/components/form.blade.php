@php $forms->setModel($task); @endphp
<div class="row">
  {!! $forms->renderFormField('issue_id', ['options' => $issues]) !!}
  {!! $forms->renderFormField('start_datetime') !!}
  {!! $forms->renderFormField('end_datetime') !!}
  {!! $forms->renderFormField('logged', ['default' => 0]) !!}
  {!! $forms->renderFormField('description') !!}
</div>
{!! $forms->renderSubmitButton($task->exists ? 'Update Task' : 'Create Task') !!}
{!! $forms->renderCancelButton(route('tasks.index')) !!}
