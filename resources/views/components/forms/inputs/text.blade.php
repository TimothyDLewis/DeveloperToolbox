<div class="{{ $containerClass }} {{ $repeatable ? 'mb-1' : 'mb-3' }}">
  @if(!$repeatable)
    <label class="form-label">{{ $field['label'] }}</label>
  @endif
  <input id="{{ $id }}" class="form-control {{ $errors->has($errorKey) || $errors->has($derivativeKey) ? 'is-invalid' : '' }}" type="text" name="{{ $name }}" value="{{ old($name, $model->{$fieldKey} ?? $default) }}" placeholder="{{ $placeholder }}" />
  @include('components.forms.error', ['errorKey' => $errorKey, 'derivativeKey' => $derivativeKey])
</div>
