<div class="input-group flex-nowrap">
  <p class="card card-body card-condensed d-inline-block">
    <code class="{{ $theme->themeVar('text-light', 'text-dark') }}">{{ strtoupper($model->{$field}) }};</code>
  </p>
  <button class="btn {{ $theme->themeVar('btn-outline-light', 'btn-outline-dark') }} hex-copy" type="button">
    <i class="fa-solid fa-copy"></i>
  </button>
</div>
