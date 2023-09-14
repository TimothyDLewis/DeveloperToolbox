<header class="d-flex flex-wrap justify-content-center px-2 py-3">
  <p class="d-flex align-items-center mb-3 mb-md-0 me-md-auto">
    <i class="fa-regular fa-2xl fa-calendar-days me-3"></i>
    <span class="fs-4">Occurrences</span>
  </p>
  <ul class="nav nav-pills">
    <li class="nav-item">
      <a href="{{ route('occurrences.index') }}" class="nav-link {{ request()->is('organization/occurrences') ? 'active' : '' }}" aria-current="page">All Occurrences</a>
    </li>
    <li class="nav-item">
      <a href="{{ route('occurrences.create') }}" class="nav-link {{ request()->is('organization/occurrences/create') ? 'active' : '' }}">New Occurrence</a>
    </li>
    @if(isset($occurrenceContext))
      <li class="nav-item">
        <a href="{{ route('occurrences.show', $occurrenceContext) }}" class="nav-link {{ request()->is("organization/occurrences/{$occurrenceContext->id}") && !request()->is("organization/occurrences/{$occurrenceContext->id}/edit") ? 'active' : '' }}">View Occurrence</a>
      </li>
      <li class="nav-item">
        <a href="{{ route('occurrences.edit', $occurrenceContext) }}" class="nav-link {{ request()->is("organization/occurrences/{$occurrenceContext->id}/edit") ? 'active' : '' }}">Edit Occurrence</a>
      </li>
      <li class="nav-item">
        <form action="{{ route('occurrences.destroy', $occurrenceContext) }}" method="POST">
          @method('DELETE')
          @csrf
          <button type="button" class="nav-link text-danger delete-occurrence">Delete Occurrence</button>
        </form>
      </li>
    @endif
  </ul>
</header>
@include('components.session-flash')
