<header class="d-flex flex-wrap justify-content-center px-2 py-3">
  <p class="d-flex align-items-center mb-3 mb-md-0 me-md-auto">
    <i class="fa-regular fa-2xl fa-bookmark me-3"></i>
    <span class="fs-4">Resources</span>
  </p>
  <ul class="nav nav-pills">
    <li class="nav-item">
      <a href="{{ route('resources.index') }}" class="nav-link {{ request()->is('organization/resources') ? 'active' : '' }}" aria-current="page">All Resources</a>
    </li>
    <li class="nav-item">
      <a href="{{ route('resources.create') }}" class="nav-link {{ request()->is('organization/resources/create') ? 'active' : '' }}">New Resource</a>
    </li>
    @if(isset($resourceContext))
      <li class="nav-item">
        <a href="{{ route('resources.edit', $resourceContext) }}" class="nav-link {{ request()->is("organization/resources/{$resourceContext->id}/edit") ? 'active' : '' }}">Edit Resource</a>
      </li>
      <li class="nav-item">
        <form action="{{ route('resources.destroy', $resourceContext) }}" method="POST">
          @method('DELETE')
          @csrf
          <button type="button" class="nav-link text-danger delete-resource">Delete Resource</button>
        </form>
      </li>
    @endif
  </ul>
</header>
@include('components.session-flash')
