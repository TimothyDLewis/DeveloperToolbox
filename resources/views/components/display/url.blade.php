@if($model->{$urlField})
  <div class="input-group flex-nowrap">
    <p class="card card-body card-condensed">
      <a href="{{ $model->{$urlField} }}" target="_blank">{{ $model->{$displayField} }}</a>
    </p>
    <button class="btn {{ $theme->themeVar('btn-outline-light', 'btn-outline-dark') }} url-copy" type="button">
      <i class="fa-solid fa-copy"></i>
    </button>
  </div>
@else
  <p class="card card-body card-condensed">
    <i class="text-secondary">No URL provided...</i>
  </p>
@endif
