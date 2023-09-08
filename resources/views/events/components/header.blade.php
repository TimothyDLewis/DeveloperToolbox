<header class="d-flex flex-wrap justify-content-center px-2 py-3">
  <p class="d-flex align-items-center mb-3 mb-md-0 me-md-auto">
    <i class="fa-regular fa-2xl fa-calendar-plus me-3"></i>
    <span class="fs-4">Events</span>
  </p>
  <ul class="nav nav-pills">
    <li class="nav-item">
      <a href="{{ route('events.index') }}" class="nav-link {{ request()->is('organization/events') ? 'active' : '' }}" aria-current="page">All Events</a>
    </li>
    <li class="nav-item">
      <a href="{{ route('events.create') }}" class="nav-link {{ request()->is('organization/events/create') ? 'active' : '' }}">New Event</a>
    </li>
    @if(isset($eventContext))
      <li class="nav-item">
        <a href="{{ route('events.show', $eventContext) }}" class="nav-link {{ request()->is("organization/events/{$eventContext->id}") && !request()->is("organization/events/{$eventContext->id}/edit") ? 'active' : '' }}">View Event</a>
      </li>
      @if($event->canEdit())
        <li class="nav-item">
          <a href="{{ route('events.edit', $eventContext) }}" class="nav-link {{ request()->is("organization/events/{$eventContext->id}/edit") ? 'active' : '' }}">Edit Event</a>
        </li>
      @endif
      <li class="nav-item">
        <form action="{{ route('events.destroy', $eventContext) }}" method="POST">
          @method('DELETE')
          @csrf
          <button type="button" class="nav-link text-danger delete-event">Delete Event</button>
        </form>
      </li>
    @endif
  </ul>
</header>
@include('components.session-flash')
