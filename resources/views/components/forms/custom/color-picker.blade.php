<div class="{{ $containerClass }} {{ $repeatable ? 'mb-1' : 'mb-3' }}">
  @if(!$repeatable)
    <label class="form-label">{{ $field['label'] }}</label>
  @endif
  <div class="input-group flex-nowrap">
    <input id="{{ $id }}" class="colorInput form-control form-control-color full-width {{ $errors->has($errorKey) || $errors->has($derivativeKey) ? 'is-invalid' : '' }}" type="color" name="{{ $name }}" value="{{ old($name, $model->{$fieldKey} ?? $default) }}" data-default-value="{{ $default }}" />
    <button class="swatchButton btn {{ $theme->themeVar('btn-outline-light', 'btn-outline-dark') }}" type="button" data-bs-toggle="dropdown">
      <i class="fa-solid fa-swatchbook"></i>
    </button>
    <ul class="dropdown-menu">
      @foreach($theme->swatches() as $label => $swatch)
        <li><a class="colorSwatch dropdown-item" href="#" style="color: {{ $swatch }};" data-color="{{ $swatch }}">{{ ucfirst($label) }}</a></li>
      @endforeach
    </ul>
  </div>
  @include('components.forms.error', ['errorKey' => $errorKey, 'derivativeKey' => $derivativeKey])
</div>
