<header class="d-flex flex-wrap justify-content-center px-2 py-3">
  <p class="d-flex align-items-center mb-3 mb-md-0 me-md-auto">
    <i class="fa-regular fa-2xl fa-layer-group me-3"></i>
    <span class="fs-4">Tasks</span>
  </p>
  <ul class="nav nav-pills">
    <li class="nav-item">
      <a href="{{ route('tasks.index') }}" class="nav-link {{ request()->is('organization/tasks') ? 'active' : '' }}" aria-current="page">All Tasks</a>
    </li>
    <li class="nav-item">
      <a href="{{ route('tasks.create') }}" class="nav-link {{ request()->is('organization/tasks/create') ? 'active' : '' }}">New Task</a>
    </li>
    @if(isset($taskContext))
      <li class="nav-item">
        <a href="{{ route('tasks.show', $taskContext) }}" class="nav-link {{ request()->is("organization/tasks/{$taskContext->id}") && !request()->is("organization/tasks/{$taskContext->id}/edit") ? 'active' : '' }}">View Task</a>
      </li>
      <li class="nav-item">
        <a href="{{ route('tasks.edit', $taskContext) }}" class="nav-link {{ request()->is("organization/tasks/{$taskContext->id}/edit") ? 'active' : '' }}">Edit Task</a>
      </li>
      <li class="nav-item">
        <form action="{{ route('tasks.destroy', $taskContext) }}" method="POST">
          @method('DELETE')
          @csrf
          <button type="button" class="nav-link text-danger delete-task">Delete Task</button>
        </form>
      </li>
    @endif
  </ul>
</header>
@include('components.session-flash')
