<div class="{{ $field['container']['class'] ?? 'col-12' }} {{ $repeatable ? 'mb-1' : 'mb-3' }}">
  <label class="form-label">{{ $field['label'] }}</label>
  <input id="{{ $id }}" class="form-control {{ $errors->has($errorKey) || $errors->has($derivativeKey) ? 'is-invalid' : '' }}" type="text" name="{{ $name }}" value="{{ old($fieldKey, $model->{$fieldKey}) }}" />
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
