<header class="d-flex flex-wrap justify-content-center px-2 py-3">
  <p class="d-flex align-items-center mb-3 mb-md-0 me-md-auto">
    <i class="fa-regular fa-2xl fa-calendar-days me-3"></i>
    <span class="fs-4">Occurences</span>
  </p>
  <ul class="nav nav-pills">
    <li class="nav-item">
      <a href="{{ route('occurences.index') }}" class="nav-link {{ request()->is('organization/occurences') ? 'active' : '' }}" aria-current="page">All Occurences</a>
    </li>
    <li class="nav-item">
      <a href="{{ route('occurences.create') }}" class="nav-link {{ request()->is('organization/occurences/create') ? 'active' : '' }}">New Occurence</a>
    </li>
    @if(isset($occurenceContext))
      <li class="nav-item">
        <a href="{{ route('occurences.show', $occurenceContext) }}" class="nav-link {{ request()->is("organization/occurences/{$occurenceContext->id}") && !request()->is("organization/occurences/{$occurenceContext->id}/edit") ? 'active' : '' }}">View Occurence</a>
      </li>
      <li class="nav-item">
        <a href="{{ route('occurences.edit', $occurenceContext) }}" class="nav-link {{ request()->is("organization/occurences/{$occurenceContext->id}/edit") ? 'active' : '' }}">Edit Occurence</a>
      </li>
      <li class="nav-item">
        <form action="{{ route('occurences.destroy', $occurenceContext) }}" method="POST">
          @method('DELETE')
          @csrf
          <button type="button" class="nav-link text-danger delete-occurence">Delete Occurence</button>
        </form>
      </li>
    @endif
  </ul>
</header>
@include('components.session-flash')
