<div class="{{ $containerClass }} mb-3">
  @if(!$repeatable)
    <label class="form-label">{{ $field['label'] }}</label>
  @endif
  <textarea id="{{ $id }}" class="form-control" rows="{{ $field['rows'] ?? 5 }}" name="{{ $name }}">{{ old($name, $model->{$fieldKey} ?? $default) }}</textarea>
</div>
