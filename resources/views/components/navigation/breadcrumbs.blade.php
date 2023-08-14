<div class="container-fluid py-2 px-3 bg-body-secondary">
  <ol class="breadcrumb mb-0">
    @if($breadcrumbs ?? null)
      <li class="breadcrumb-item">
        <a class="{{ $theme->themeClass('text-white', 'text-black') }}" href="{{ url('/') }}">Dashboard</a>
      </li>
      @foreach($breadcrumbs as $breadcrumb)
        @if($breadcrumb->active ?? false)
          <li class="breadcrumb-item active">
            {{ $breadcrumb->label }}
          </li>
        @else
          <li class="breadcrumb-item">
            <a class="{{ $theme->themeClass('text-white', 'text-black') }}" href="{{ $breadcrumb->path }}">{{ $breadcrumb->label }}</a>
          </li>
        @endif
      @endforeach
    @else
      <li class="breadcrumb-item active {{ $theme->themeClass('text-white', 'text-black') }}">Dashboard</li>
    @endif
  </ol>
</div>
