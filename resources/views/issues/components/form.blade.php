@php $forms->setModel($issue); @endphp
<div class="row">
  {!! $forms->renderFormField('title') !!}
  {!! $forms->renderFormField('code') !!}
  {!! $forms->renderFormField('external_url') !!}
  @if(!$issue->exists)
    {!! $forms->renderFormField('project_id', ['options' => $projects]) !!}
  @else
    <div class="col-12 col-sm-6 col-md-4 mb-3">
      <label class="form-label">Project</label>
      <p class="card card-body card-condensed">
        <i class="text-secondary">{{ $issue->project->title }}</i>
      </p>
    </div>
  @endif
  {!! $forms->renderFormField('estimate_option_id', ['options' => $estimateOptions]) !!}
  {!! $forms->renderFormField('status_option_id', ['options' => $statusOptions]) !!}
  {!! $forms->renderFormField('description') !!}
</div>
{!! $forms->renderSubmitButton($issue->exists ? 'Update Issue' : 'Create Issue') !!}
{!! $forms->renderCancelButton(route('issues.index')) !!}
