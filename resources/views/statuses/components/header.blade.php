<header class="d-flex flex-wrap justify-content-center px-2 py-3">
  <p class="d-flex align-items-center mb-3 mb-md-0 me-md-auto">
    <i class="fa-regular fa-2xl fa-bars-progress me-3"></i>
    <span class="fs-4">Statuses</span>
  </p>
  <ul class="nav nav-pills">
    <li class="nav-item">
      <a href="{{ route('statuses.index') }}" class="nav-link {{ request()->is('organization/statuses') ? 'active' : '' }}" aria-current="page">All Statuses</a>
    </li>
    <li class="nav-item">
      <a href="{{ route('statuses.create') }}" class="nav-link {{ request()->is('organization/statuses/create') ? 'active' : '' }}">New Status</a>
    </li>
    @if(isset($statusContext))
      <li class="nav-item">
        <a href="{{ route('statuses.show', $statusContext) }}" class="nav-link {{ request()->is("organization/statuses/{$statusContext->id}") && !request()->is("organization/statuses/{$statusContext->id}/edit") ? 'active' : '' }}">View Status</a>
      </li>
      <li class="nav-item">
        <a href="{{ route('statuses.edit', $statusContext) }}" class="nav-link {{ request()->is("organization/statuses/{$statusContext->id}/edit") ? 'active' : '' }}">Edit Status</a>
      </li>
      <li class="nav-item">
        <form action="{{ route('statuses.destroy', $statusContext) }}" method="POST">
          @method('DELETE')
          @csrf
          <button type="button" class="nav-link text-danger delete-status">Delete Status</button>
        </form>
      </li>
    @endif
  </ul>
</header>
@include('components.session-flash')
