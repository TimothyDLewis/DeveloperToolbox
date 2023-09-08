<div id="organization-sidebar" class="d-none d-sm-none d-md-none d-lg-flex flex-column flex-shrink-0 p-2 bg-body-tertiary">
  <ul class="nav nav-pills flex-column mb-auto">
    @foreach($sidebarLinks as $sidebarLink)
      <li class="nav-item">
        @if($sidebarLink->isDropdown)
          <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 toggle-dropdown ms-1" data-bs-toggle="collapse" data-bs-target="#{{ $sidebarLink->dropdownId }}" aria-expanded="true">
            {{ $sidebarLink->label }}
            <i class="toggle-icon fa-solid {{ $sidebarLink->isOpen ? 'fa-angle-down' : 'fa-angle-right' }} ms-3"></i>
          </button>
          <div class="collapse {{ $sidebarLink->isOpen ? 'show' : '' }}" id="{{ $sidebarLink->dropdownId }}">
            <div class="d-none d-sm-none d-md-none d-lg-flex flex-column flex-shrink-0 px-3 bg-body-tertiary">
              <ul class="nav nav-pills flex-column mb-auto">
                @foreach($sidebarLink->children as $childSidebarLink)
                  <a href="{{ $childSidebarLink->href }}" class="nav-link {{ $childSidebarLink->isActive ? 'active' : $theme->themeVar('text-white', 'text-black') }}" aria-current="page">
                    {!! $childSidebarLink->icon !!}
                    {{ $childSidebarLink->label }}
                  </a>
                @endforeach
              </ul>
            </div>
          </div>
        @else
          <a href="{{ $sidebarLink->href }}" class="nav-link {{ $sidebarLink->isActive ? 'active' : $theme->themeVar('text-white', 'text-black') }}" aria-current="page">
            {!! $sidebarLink->icon !!}
            {{ $sidebarLink->label }}
          </a>
        @endif
      </li>
    @endforeach
  </ul>
</div>
<div id="organization-sidebar-small" class="d-xs-flex d-md-flex d-lg-none flex-column flex-shrink-0 bg-body-secondary">
  <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
    @foreach($sidebarLinks as $sidebarLink)
      @if($sidebarLink->isDropdown)
        @foreach($sidebarLink->children as $childSidebarLink)
          <li class="nav-item">
            <a href="{{ $childSidebarLink->href }}" class="nav-link py-3 border-bottom rounded-0 {{ $childSidebarLink->isActive ? 'active' : $theme->themeVar('text-white', 'text-black') }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $childSidebarLink->label }}">
              {!! $childSidebarLink->icon !!}
            </a>
          </li>
        @endforeach
      @else
        <li class="nav-item">
          <a href="{{ $sidebarLink->href }}" class="nav-link py-3 border-bottom rounded-0 {{ $sidebarLink->isActive ? 'active' : $theme->themeVar('text-white', 'text-black') }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $sidebarLink->label }}">
            {!! $sidebarLink->icon !!}
          </a>
        </li>
      @endif
    @endforeach
  </ul>
</div>
<div class="vertical-divider vertical-vr"></div>
