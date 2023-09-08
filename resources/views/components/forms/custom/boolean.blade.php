@php $errorClass = $errors->has($errorKey) || $errors->has($derivativeKey) ? 'is-invalid' : ''; @endphp
<div class="{{ $containerClass }} {{ $repeatable ? 'mb-1' : 'mb-3' }} {{ $errorClass }}">
  @if(!$repeatable)
    <label class="form-label mb-2">{{ $field['label'] }}</label>
  @endif
  <div class="form-check form-switch {{ !$repeatable ? 'mt-1' : '' }}">
    <input type="hidden" name="{{ $name }}" value="{{ old($name, $model->{$fieldKey} ?? $default) }}" />
    <input id="{{ $id }}" class="form-check-input form-check-input-custom {{ $inputClass }} {{ $errorClass }}" type="checkbox" @checked(old($name, $model->{$fieldKey} ?? $default) == 1) />
  </div>
  @include('components.forms.error', ['errorKey' => $errorKey, 'derivativeKey' => $derivativeKey])
</div>
