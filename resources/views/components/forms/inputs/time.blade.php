<div class="{{ $containerClass }} {{ $repeatable ? 'mb-1' : 'mb-3' }}">
  {{ $derivativeKey }}
  @if(!$repeatable)
    <label class="form-label">{{ $field['label'] }}</label>
  @endif
  <input id="{{ $id }}" class="form-control {{ $errors->has($errorKey) || $errors->has($derivativeKey) ? 'is-invalid' : '' }}" type="time" name="{{ $name }}" step="{{ $step }}" value="{{ old($name, $model->{$fieldKey} ?? $default) }}" placeholder="{{ $placeholder }}" {{ $readonly ? 'readonly' : '' }} />
  @include('components.forms.error', ['errorKey' => $errorKey, 'derivativeKey' => $derivativeKey])
</div>
