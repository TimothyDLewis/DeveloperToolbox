<div class="{{ $field['container']['class'] ?? 'col-12' }} {{ $repeatable ? 'mb-1' : 'mb-3' }}">
  @if(!$repeatable)
    <label class="form-label">{{ $field['label'] }}</label>
  @endif
  <select id="{{ $id }}" class="form-control {{ $errors->has($errorKey) || $errors->has($derivativeKey) ? 'is-invalid' : '' }}" name="{{ $name }}">
    <option value="">None Selected</option>
    @foreach($options ?? [] as $option)
      <option value="{{ $option->id }}" @selected(old($name, $model->{$fieldKey} ?? $default) == $option->id)>{{ $option->label }}</option>
    @endforeach
  </select>
  @if($errors->has($errorKey) || $errors->has($derivativeKey))
    <div class="invalid-feedback">
      @if($errors->has($errorKey))
        {{ $errors->first($errorKey) }}
      @elseif($errors->has($derivativeKey))
        {{ $errors->first($derivativeKey) }}
      @endif
    </div>
  @endif
</div>
