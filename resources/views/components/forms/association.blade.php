<div class="{{ $containerClass }}">
  <div class="form-check form-switch">
    <input id="{{ $id }}" class="form-check-input form-check-input-custom {{ $inputClass }}" type="checkbox" name="{{ $name }}[]" value="{{ $default }}" @checked(in_array($default, old($name, []))) />
  </div>
</div>
