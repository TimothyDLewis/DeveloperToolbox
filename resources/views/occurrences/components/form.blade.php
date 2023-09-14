@php
  $forms->setModel($occurrence);
  $allDay = old('all_day', $occurrence->all_day ?? 0);
@endphp
<div class="row">
  {!! $forms->renderFormField('event_id', ['options' => $events]) !!}
  {!! $forms->renderFormField('all_day', ['containerClass' => 'col-12 col-sm-2', 'default' => 0]) !!}
  {!! $forms->renderFormField('start_datetime', ['containerClass' => ($allDay ? 'col-12 col-sm-10' : 'col-12 col-sm-5'), 'type' => $allDay ? 'date' : 'datetime']) !!}
  {!! $forms->renderFormField('end_datetime', ['containerClass' => 'col-12 col-sm-5' . ($allDay ? ' hidden' : '')]) !!}
</div>
{!! $forms->renderSubmitButton($occurrence->exists ? 'Update Occurrence' : 'Create Occurrence') !!}
{!! $forms->renderCancelButton(route('occurrences.index')) !!}
