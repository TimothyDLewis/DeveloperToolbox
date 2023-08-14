@php $forms->setModel($project); @endphp
<div class="row">
  {!! $forms->renderFormField('title') !!}
  {!! $forms->renderFormField('code') !!}
  {!! $forms->renderFormField('source_code_management_url') !!}
  {!! $forms->renderFormField('description') !!}
</div>
{!! $forms->renderSubmitButton($project->exists ? 'Update Project' : 'Create Project') !!}
{!! $forms->renderCancelButton(route('projects.index')) !!}
