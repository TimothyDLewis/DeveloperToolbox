<header class="d-flex flex-wrap justify-content-center px-2 py-3">
  <p class="d-flex align-items-center mb-3 mb-md-0 me-md-auto">
    <i class="fa-regular fa-2xl fa-arrows-split-up-and-left fa-rotate-180 me-3"></i>
    <span class="fs-4">Sprints</span>
  </p>
  <ul class="nav nav-pills">
    <li class="nav-item">
      <a href="{{ route('sprints.index') }}" class="nav-link {{ request()->is('organization/sprints') ? 'active' : '' }}" aria-current="page">All Sprints</a>
    </li>
    <li class="nav-item">
      <a href="{{ route('sprints.create') }}" class="nav-link {{ request()->is('organization/sprints/create') ? 'active' : '' }}">New Sprint</a>
    </li>
    @if(isset($sprintContext))
      <li class="nav-item">
        <a href="{{ route('sprints.show', $sprintContext) }}" class="nav-link {{ request()->is("organization/sprints/{$sprintContext->id}") && !request()->is("organization/sprints/{$sprintContext->id}/edit") ? 'active' : '' }}">View Sprint</a>
      </li>
      <li class="nav-item">
        <a href="{{ route('sprints.edit', $sprintContext) }}" class="nav-link {{ request()->is("organization/sprints/{$sprintContext->id}/edit") ? 'active' : '' }}">Edit Sprint</a>
      </li>
      <li class="nav-item">
        <form action="{{ route('sprints.destroy', $sprintContext) }}" method="POST">
          @method('DELETE')
          @csrf
          <button type="button" class="nav-link text-danger delete-sprint">Delete Sprint</button>
        </form>
      </li>
    @endif
  </ul>
</header>
@include('components.session-flash')
