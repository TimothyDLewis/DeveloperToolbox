<div id="organization-sidebar" class="d-none d-sm-none d-md-none d-lg-flex flex-column flex-shrink-0 p-3 bg-body-secondary">
  <ul class="nav nav-pills flex-column mb-auto">
    @foreach($sidebarLinks as $sidebarLink)
      <li class="nav-item">
        <a href="{{ $sidebarLink->href }}" class="nav-link {{ $sidebarLink->isActive ? 'active' : $theme->themeClass('text-white', 'text-black') }}" aria-current="page">
          {!! $sidebarLink->icon !!}
          {{ $sidebarLink->label }}
        </a>
      </li>
    @endforeach
  </ul>
</div>
<div id="organization-sidebar-small" class="d-xs-flex d-md-flex d-lg-none flex-column flex-shrink-0 bg-body-secondary">
  <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
    @foreach($sidebarLinks as $sidebarLink)
      <li class="nav-item">
        <a href="{{ $sidebarLink->href }}" class="nav-link py-3 border-bottom rounded-0 {{ $sidebarLink->isActive ? 'active' : $theme->themeClass('text-white', 'text-black') }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $sidebarLink->label }}">
          {!! $sidebarLink->icon !!}
        </a>
      </li>
    @endforeach
  </ul>
</div>
<div class="vertical-divider vertical-vr"></div>
