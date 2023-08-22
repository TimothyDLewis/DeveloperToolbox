<header class="d-flex flex-wrap justify-content-center px-2 py-3">
  <p class="d-flex align-items-center mb-3 mb-md-0 me-md-auto">
    <i class="fa-regular fa-2xl fa-cubes me-3"></i>
    <span class="fs-4">Issues</span>
  </p>
  <ul class="nav nav-pills">
    <li class="nav-item">
      <a href="{{ route('issues.index') }}" class="nav-link {{ request()->is('organization/issues') ? 'active' : '' }}" aria-current="page">All Issues</a>
    </li>
    <li class="nav-item">
      <a href="{{ route('issues.create') }}" class="nav-link {{ request()->is('organization/issues/create') ? 'active' : '' }}">New Issue</a>
    </li>
    @if(isset($issueContext))
      <li class="nav-item">
        <a href="{{ route('issues.show', $issueContext) }}" class="nav-link {{ request()->is("organization/issues/{$issueContext->id}") && !request()->is("organization/issues/{$issueContext->id}/edit") ? 'active' : '' }}">View Issue</a>
      </li>
      <li class="nav-item">
        <a href="{{ route('issues.edit', $issueContext) }}" class="nav-link {{ request()->is("organization/issues/{$issueContext->id}/edit") ? 'active' : '' }}">Edit Issue</a>
      </li>
      <li class="nav-item">
        <form action="{{ route('issues.destroy', $issueContext) }}" method="POST">
          @method('DELETE')
          @csrf
          <button type="button" class="nav-link text-danger delete-issue">Delete Issue</button>
        </form>
      </li>
    @endif
  </ul>
</header>
@include('components.session-flash')
