<header class="d-flex flex-wrap justify-content-center px-2 py-3">
  <p class="d-flex align-items-center mb-3 mb-md-0 me-md-auto">
    <i class="fa-regular fa-2xl fa-clipboard-list me-3"></i>
    <span class="fs-4">Projects</span>
  </p>
  <ul class="nav nav-pills">
    <li class="nav-item">
      <a href="{{ route('projects.index') }}" class="nav-link {{ request()->is('organization/projects') ? 'active' : '' }}" aria-current="page">All Projects</a>
    </li>
    <li class="nav-item">
      <a href="{{ route('projects.create') }}" class="nav-link {{ request()->is('organization/projects/create') ? 'active' : '' }}">New Project</a>
    </li>
    @if(isset($projectContext))
      <li class="nav-item">
        <a href="{{ route('projects.show', $projectContext) }}" class="nav-link {{ request()->is("organization/projects/{$projectContext->id}") && !request()->is("organization/projects/{$projectContext->id}/edit") ? 'active' : '' }}">View Project</a>
      </li>
      <li class="nav-item">
        <a href="{{ route('projects.edit', $projectContext) }}" class="nav-link {{ request()->is("organization/projects/{$projectContext->id}/edit") ? 'active' : '' }}">Edit Project</a>
      </li>
      <li class="nav-item">
        <form action="{{ route('projects.destroy', $projectContext) }}" method="POST">
          @method('DELETE')
          @csrf
          <button type="button" class="nav-link text-danger delete-project">Delete Project</button>
        </form>
      </li>
    @endif
  </ul>
</header>
@include('components.session-flash')
