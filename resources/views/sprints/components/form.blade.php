@php $forms->setModel($sprint); @endphp
<div class="row">
  {!! $forms->renderFormField('title') !!}
  {!! $forms->renderFormField('start_date') !!}
  {!! $forms->renderFormField('end_date') !!}
  {!! $forms->renderFormField('description') !!}
</div>
@if(!$sprint->exists && !$issues->isEmpty())
  @php $forms->setModel(new Issue()); @endphp
  <div class="row">
    <div class="col-12">
      <label class="form-label d-block">Issues</label>
      <table id="sprintIssues" class="table table-bordered table-vertical-center {{ $theme->themeVar('table-dark', 'table-light') }}">
        <thead>
          <tr>
            <th class="th-min"></th>
            {!! $forms->renderRepeatableFormHeader('code', 'th-min') !!}
            {!! $forms->renderRepeatableFormHeader('title') !!}
            {!! $forms->renderRepeatableFormHeader('project_id') !!}
            {!! $forms->renderRepeatableFormHeader('estimate_option_id', 'th-min th-estimate-option text-center', 2) !!}
            {!! $forms->renderRepeatableFormHeader('status_option_id', 'th-min th-status-option') !!}
          </tr>
        </thead>
        @php $forms->setModel($sprint); @endphp
        <tbody>
          @forelse($issues as $index => $issue)
            <tr>
              <td>{!! $forms->renderFormField('issues', ['default' => $issue->id]) !!}</td>
              <td class="td-min text-center">{!! $issue->code_display !!}</td>
              <td>{{ $issue->title }}</td>
              <td>{{ $issue->project->title }}</td>
              <td class="td-min text-center">{!! $issue->estimateOption->label_display_alt !!}</td>
              <td class="td-min text-center">{!! $issue->estimateOption->value_display !!}</td>
              <td class="td-status-option text-center">{!! $issue->statusOption->label_display !!}</td>
            </tr>
          @empty
            <tr>
              <td colspan="5">
                <i class="text-secondary">No Issues Available...</i>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endif
{!! $forms->renderSubmitButton($sprint->exists ? 'Update Sprint' : 'Create Sprint') !!}
{!! $forms->renderCancelButton(route('sprints.index')) !!}
