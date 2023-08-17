<div class="{{ $containerClass }} {{ $repeatable ? 'mb-1' : 'mb-3' }}">
  <div class="form-check form-switch">
    <input id="{{ $id }}" class="initialStatusOption form-check-input form-check-input-custom {{ $errors->has($errorKey) || $errors->has($derivativeKey) ? 'is-invalid' : '' }}" type="checkbox" name="{{ $name }}" value="1" @checked(old($name, $model->{$fieldKey} ?? $default) == '1') />
  </div>
  @include('components.forms.error', ['fieldKey' => $fieldKey, 'derivativeKey' => $derivativeKey])
</div>
