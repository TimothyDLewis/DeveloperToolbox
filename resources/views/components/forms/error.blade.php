@if($errors->has($errorKey) || $errors->has($derivativeKey))
  <div class="invalid-feedback">
    @if($errors->has($errorKey))
      {{ $errors->first($errorKey) }}
    @elseif($errors->has($derivativeKey))
      {{ $errors->first($derivativeKey) }}
    @endif
  </div>
@endif
