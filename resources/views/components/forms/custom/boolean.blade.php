<div class="{{ $field['container']['class'] ?? 'col-12' }} {{ $repeatable ? 'mb-1' : 'mb-3' }}">
  <div class="form-check form-switch">
    <input id="{{ $id }}" class="initialStatusOption form-check-input form-check-input-custom {{ $errors->has($errorKey) || $errors->has($derivativeKey) ? 'is-invalid' : '' }}" type="checkbox" name="{{ $name }}" value="1" @checked(old($name, $model->{$fieldKey} ?? $default) == '1') />
  </div>
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
