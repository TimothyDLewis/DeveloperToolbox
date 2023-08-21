@php $forms->setModel($resource); @endphp
<div class="row">
  {!! $forms->renderFormField('title') !!}
  {!! $forms->renderFormField('project_id', ['options' => $projects]) !!}
  {!! $forms->renderFormField('url') !!}
  {!! $forms->renderFormField('label') !!}
  {!! $forms->renderFormField('text_color', ['default' => $theme->themeVar('#f8f9fa', '#212529')]) !!}</td>
  {!! $forms->renderFormField('background_color', ['default' => $theme->themeVar('#212529', '#f8f9fa')]) !!}</td>
  {!! $forms->renderFormField('description') !!}
</div>
{!! $forms->renderSubmitButton($resource->exists ? 'Update Resource' : 'Create Resource') !!}
{!! $forms->renderCancelButton(route('resources.index')) !!}
