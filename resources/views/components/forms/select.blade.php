<div class="{{ $containerClass }} {{ $repeatable ? 'mb-1' : 'mb-3' }}">
  @if(!$repeatable)
    <label class="form-label">{{ $field['label'] }}</label>
  @endif
  <select id="{{ $id }}" class="form-control {{ $errors->has($errorKey) || $errors->has($derivativeKey) ? 'is-invalid' : '' }}" name="{{ $name }}">
    <option value="">None Selected</option>
    @foreach($options ?? [] as $option)
      <option value="{{ $option->id }}" @selected(old($name, $model->{$fieldKey} ?? $default) == $option->id)>{{ $option->label }}</option>
    @endforeach
  </select>
  @include('components.forms.error', ['fieldKey' => $fieldKey, 'derivativeKey' => $derivativeKey])
</div>
