<div class="{{ $containerClass }} {{ $repeatable ? 'mb-1' : 'mb-3' }}">
  @if(!$repeatable)
    <label class="form-label">{{ $field['label'] }}</label>
  @endif
  <select id="{{ $id }}" class="form-control {{ $errors->has($errorKey) || $errors->has($derivativeKey) ? 'is-invalid' : '' }}" name="{{ $name }}">
    @foreach($options ?? [] as $option)
      <option value="{{ $option->value }}" @selected($model->{$fieldKey}->value == $option->value)>{{ $option->label }}</option>
    @endforeach
  </select>
  @include('components.forms.error', ['errorKey' => $errorKey, 'derivativeKey' => $derivativeKey])
</div>
