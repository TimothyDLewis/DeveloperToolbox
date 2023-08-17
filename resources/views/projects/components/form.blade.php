@php $forms->setModel($project); @endphp
<div class="row">
  {!! $forms->renderFormField('title') !!}
  {!! $forms->renderFormField('code') !!}
  {!! $forms->renderFormField('source_code_management_url') !!}
  @if(!$project->exists)
    {!! $forms->renderFormField('estimate_id', ['options' => $estimates]) !!}
    {!! $forms->renderFormField('status_id', ['options' => $statuses]) !!}
  @else
    <div class="col-12 col-sm-6 mb-3">
      <label class="form-label">Estimate</label>
      <p class="card card-body card-condensed">
        <i class="text-secondary">{{ $project->estimate->title }}</i>
      </p>
    </div>
    <div class="col-12 col-sm-6 mb-3">
      <label class="form-label">Status</label>
      <p class="card card-body card-condensed">
        <i class="text-secondary">{{ $project->status->title }}</i>
      </p>
    </div>
  @endif
  {!! $forms->renderFormField('description') !!}
</div>
{!! $forms->renderSubmitButton($project->exists ? 'Update Project' : 'Create Project') !!}
{!! $forms->renderCancelButton(route('projects.index')) !!}
