<header class="d-flex flex-wrap justify-content-center px-2 py-3">
  <p class="d-flex align-items-center mb-3 mb-md-0 me-md-auto">
    <i class="fa-regular fa-2xl fa-clipboard-list me-3"></i>
    <span class="fs-4">Projects</span>
    <sup>
      <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#projectInfoModal">
        <i class="fa-solid fa-lightbulb text-primary"></i>
      </button>
    </sup>
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
<div class="modal fade" id="projectInfoModal" tabindex="-1" aria-labelledby="projectInfoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="projectInfoModalLabel">Help Topic > Projects</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body mb-0">
        <p>Projects are the main organizational tool for the Developer Toolbox.</p>
        <p>A Project has the following fields:</p>
        <ul class="list-unstyled">
          <li><code class="me-1">string</code> Title</li>
          <ul><li>A unique title for each project</li></ul>
          <li><code class="me-1">string</code> Slug</li>
          <ul><li>Auto-generated based on the title</li></ul>
          <li><code class="me-1">string</code> Code</li>
          <ul><li>A short, unique identifying code</li></ul>
          <li><code class="me-1">string</code> Source Code Management (SCM) URL</li>
          <ul><li>Optional external URL to an SCM Repository (GitHub, etc.)</li></ul>
          <li><code class="me-1">string</code> Description</li>
          <ul><li>Additional information about the project's purpose and scope</li></ul>
        </ul>
        <p>A Project has the following relationships:</p>
        <ul class="list-unstyled mb-0">
          <li><code class="me-1">BelongsTo (1 <-> 1)</code> Estimate</li>
          <ul><li>via <code>`projects.estimate_id`</code></li></ul>
          <li><code class="me-1">HasMany (1 <-> N)</code> Issue</li>
          <ul><li>via <code>`issues.project_id`</code></li></ul>
          <li><code class="me-1">HasMany (1 <-> N)</code> Resource</li>
          <ul><li>via <code>`resources.project_id`</code></li></ul>
          <li><code class="me-1">BelongsTo (1 <-> 1)</code> Status</li>
          <ul><li>via <code>`projects.status_id`</code></li></ul>
        </ul>
      </div>
    </div>
  </div>
</div>
