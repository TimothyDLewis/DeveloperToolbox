@php
  $forms->setModel($occurence);
  $allDay = old('all_day', $occurence->all_day ?? 0);
@endphp
<div class="row">
  {!! $forms->renderFormField('event_id', ['options' => $events]) !!}
  {!! $forms->renderFormField('all_day', ['containerClass' => 'col-12 col-sm-2', 'default' => 0]) !!}
  {!! $forms->renderFormField('start_datetime', ['containerClass' => ($allDay ? 'col-12 col-sm-10' : 'col-12 col-sm-5'), 'type' => $allDay ? 'date' : 'datetime']) !!}
  {!! $forms->renderFormField('end_datetime', ['containerClass' => 'col-12 col-sm-5' . ($allDay ? ' hidden' : '')]) !!}
</div>
{!! $forms->renderSubmitButton($occurence->exists ? 'Update Occurence' : 'Create Occurence') !!}
{!! $forms->renderCancelButton(route('occurences.index')) !!}
