@php $forms->setModel($eventType); @endphp
<div class="row">
  {!! $forms->renderFormField('title') !!}
  {!! $forms->renderFormField('text_color', ['default' => $theme->themeVar('#f8f9fa', '#212529')]) !!}
  {!! $forms->renderFormField('background_color', ['default' => $theme->themeVar('#212529', '#f8f9fa')]) !!}
  {!! $forms->renderFormField('affects_productivity') !!}
  {!! $forms->renderFormField('description') !!}
</div>
{!! $forms->renderSubmitButton($eventType->exists ? 'Update Event Type' : 'Create Event Type') !!}
{!! $forms->renderCancelButton(route('event-types.index')) !!}
