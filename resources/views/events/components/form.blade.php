@php
  $forms->setModel($event);
  $timeShown = $event->recurrence !== EventRecurrence::NoRecurrence && $event->recurrence !== EventRecurrence::SprintWeekly;
  $daysShown = $event->recurrence === EventRecurrence::SprintWeekly;
@endphp
<div class="row">
  {!! $forms->renderFormField('title') !!}
  {!! $forms->renderFormField('event_type_id', ['options' => $eventTypes]) !!}
  {!! $forms->renderFormField('affects_productivity', ['default' => 0]) !!}
  {!! $forms->renderFormField('recurrence', ['containerClass' => 'col-12', 'options' => $eventRecurrences, 'derivativeKey' => 'recurrence_days_enabled']) !!}
  {!! $forms->renderFormField('recurrence_start_time', ['containerClass' => 'col-12 col-sm-6 col-md-4' . ($timeShown ? '' : ' hidden')]) !!}
  {!! $forms->renderFormField('recurrence_end_time', ['containerClass' => 'col-12 col-sm-6 col-md-4' . ($timeShown ? '' : ' hidden')]) !!}
  {!! $forms->renderFormField('allows_weekends', ['containerClass' => 'col-12 col-sm-6 col-md-4' . ($timeShown ? '' : ' hidden'), 'default' => 0]) !!}
</div>
  @php $forms->setModel($days->first()); @endphp
  <table id="recurrenceDays" class="table table-bordered {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center {{ $daysShown ? '' : 'hidden' }}">
    <thead>
      <tr>
        <th class="td-min text-center"></th>
        {!! $forms->renderRepeatableFormHeader('enabled', 'th-min text-center') !!}
        {!! $forms->renderRepeatableFormHeader('recurrence_start_time') !!}
        {!! $forms->renderRepeatableFormHeader('recurrence_end_time') !!}
      </tr>
    </thead>
    <tbody>
      @foreach($days as $day)
        @php $forms->setModel($day); @endphp
        <tr>
          <td class="td-min text-center">{{ $day->label }}</td>
          <td class="td-min text-center">{!! $forms->renderRepeatableFormField('enabled', 'recurrence_days', $day->key) !!}</td>
          <td>{!! $forms->renderRepeatableFormField('recurrence_start_time', 'recurrence_days', $day->key, ['readonly' => $day->enabled != '1']) !!}</td>
          <td>{!! $forms->renderRepeatableFormField('recurrence_end_time', 'recurrence_days', $day->key, ['readonly' => $day->enabled != '1']) !!}</td>
        </td>
      @endforeach
    </tbody>
  </table>
@php $forms->setModel($event); @endphp
<div class="row">
  {!! $forms->renderFormField('description') !!}
</div>
{!! $forms->renderSubmitButton($event->exists ? 'Update Event' : 'Create Event') !!}
{!! $forms->renderCancelButton(route('events.index')) !!}
