<div class="{{ $field['container']['class'] ?? 'col-12' }} mb-3">
  <label class="form-label">{{ $field['label'] }}</label>
  <textarea id="{{ $id }}" class="form-control" rows="{{ $field['rows'] ?? 5 }}" name="{{ $field['name'] }}">{{ old($fieldKey, $model->{$fieldKey}) }}</textarea>
</div>
