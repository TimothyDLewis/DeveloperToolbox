@if($sessionFlash = session()->get('sessionFlash', null))
  <div class="alert alert-{{ $sessionFlash->cssClass }} alert-dismissible fade show mb-3">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @if($sessionFlash->icon)
      <i class="{{ $sessionFlash->icon }}"></i>
    @endif
    {!! $sessionFlash->message !!}
  </div>
@endif
