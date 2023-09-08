<header class="d-flex flex-wrap justify-content-center px-2 py-3">
  <p class="d-flex align-items-center mb-3 mb-md-0 me-md-auto">
    <i class="fa-regular fa-2xl fa-book me-3"></i>
    <span class="fs-4">Event Types</span>
  </p>
  <ul class="nav nav-pills">
    <li class="nav-item">
      <a href="{{ route('event-types.index') }}" class="nav-link {{ request()->is('organization/event-types') ? 'active' : '' }}" aria-current="page">All Event Types</a>
    </li>
    <li class="nav-item">
      <a href="{{ route('event-types.create') }}" class="nav-link {{ request()->is('organization/event-types/create') ? 'active' : '' }}">New Event Type</a>
    </li>
    @if(isset($eventTypeContext))
      <li class="nav-item">
        <a href="{{ route('event-types.show', $eventTypeContext) }}" class="nav-link {{ request()->is("organization/event-types/{$eventTypeContext->id}") && !request()->is("organization/event-types/{$eventTypeContext->id}/edit") ? 'active' : '' }}">View Event Type</a>
      </li>
      <li class="nav-item">
        <a href="{{ route('event-types.edit', $eventTypeContext) }}" class="nav-link {{ request()->is("organization/event-types/{$eventTypeContext->id}/edit") ? 'active' : '' }}">Edit Event Type</a>
      </li>
      <li class="nav-item">
        <form action="{{ route('event-types.destroy', $eventTypeContext) }}" method="POST">
          @method('DELETE')
          @csrf
          <button type="button" class="nav-link text-danger delete-event-type">Delete Event Type</button>
        </form>
      </li>
    @endif
  </ul>
</header>
@include('components.session-flash')
