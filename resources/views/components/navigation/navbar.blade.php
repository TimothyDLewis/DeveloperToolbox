<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ url('/') }}">Developer Toolbox</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar">
      <ul class="navbar-nav me-auto">
        @foreach($navbarLinks as $navbarLink)
          <li class="nav-item">
            <a class="nav-link {{ $navbarLink->isActive ? 'active' : '' }}" href="{{ $navbarLink->href }}">{{ $navbarLink->label }}</a>
          </li>
        @endforeach
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="https://laravel.com/" target="_blank">
            Powered by <i class="fab fa-laravel mx-1"></i> Laravel <code class="ms-3">{{ app()->version() }}</code>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="fa-solid {{ $theme->themeClass('fa-sun', 'fa-moon') }} ms-2"></i>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
