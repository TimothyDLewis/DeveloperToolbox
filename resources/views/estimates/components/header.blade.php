<header class="d-flex flex-wrap justify-content-center px-2 py-3">
  <p class="d-flex align-items-center mb-3 mb-md-0 me-md-auto">
    <i class="fa-regular fa-2xl fa-list-check me-3"></i>
    <span class="fs-4">Estimates</span>
  </p>
  <ul class="nav nav-pills">
    <li class="nav-item">
      <a href="{{ route('estimates.index') }}" class="nav-link {{ request()->is('organization/estimates') ? 'active' : '' }}" aria-current="page">All Estimates</a>
    </li>
    <li class="nav-item">
      <a href="{{ route('estimates.create') }}" class="nav-link {{ request()->is('organization/estimates/create') ? 'active' : '' }}">New Estimate</a>
    </li>
    @if(isset($estimateContext))
      <li class="nav-item">
        <a href="{{ route('estimates.show', $estimateContext) }}" class="nav-link {{ request()->is("organization/estimates/{$estimateContext->id}") && !request()->is("organization/estimates/{$estimateContext->id}/edit") ? 'active' : '' }}">View Estimate</a>
      </li>
      <li class="nav-item">
        <a href="{{ route('estimates.edit', $estimateContext) }}" class="nav-link {{ request()->is("organization/estimates/{$estimateContext->id}/edit") ? 'active' : '' }}">Edit Estimate</a>
      </li>
      <li class="nav-item">
        <form action="{{ route('estimates.destroy', $estimateContext) }}" method="POST">
          @method('DELETE')
          @csrf
          <button type="button" class="nav-link text-danger delete-estimate">Delete Estimate</button>
        </form>
      </li>
    @endif
  </ul>
</header>
@include('components.session-flash')
