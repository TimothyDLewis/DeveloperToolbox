@if($sessionFlash = session()->get('sessionFlash', null))
  <div class="alert alert-{{ $sessionFlash->cssClass }} alert-dismissible fade show mb-3">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @if($sessionFlash->icon)
      <i class="{{ $sessionFlash->icon }} me-1"></i>
    @endif
    {!! $sessionFlash->message !!}
    @if($errors->count())
    <div id="errorContainer" class="mt-3">
      <span id="toggleErrors">
        <i class="fa-solid fa-eye me-1"></i> Show Errors
      </span>
      <ul id="errorList" class="mt-3 mb-0 hidden">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
  </div>
@endif
