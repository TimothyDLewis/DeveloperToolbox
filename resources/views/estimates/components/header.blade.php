<header class="d-flex flex-wrap justify-content-center px-2 py-3">
  <p class="d-flex align-items-center mb-3 mb-md-0 me-md-auto">
    <i class="fa-regular fa-2xl fa-list-check me-3"></i>
    <span class="fs-4">Estimates</span>
    <sup>
      <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#estimateInfoModal">
        <i class="fa-solid fa-lightbulb text-primary"></i>
      </button>
    </sup>
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
<div class="modal fade" id="estimateInfoModal" tabindex="-1" aria-labelledby="estimateInfoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="estimateInfoModalLabel">Help Topic > Estimates and Estimate Options</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body mb-0">
        <p>An Estimate and its associated Estimate Options is a customizable series of values used to determine effort for a given issue. Common examples include a Fibonacci System (0, 1, 2, 3, 5, 8, ...) or T-Shirt Sizes (XS, SM, MD, LG, XL, ...)</p>
        <p>An Estimate has the following fields:</p>
        <ul class="list-unstyled">
          <li><code class="me-1">string</code> Title</li>
          <ul><li>A unique title for each estimate</li></ul>
          <li><code class="me-1">string</code> Slug</li>
          <ul><li>Auto-generated based on the title</li></ul>
          <li><code class="me-1">string</code> Description</li>
          <ul><li>Additional information and details about the estimate</li></ul>
        </ul>
        <p>An Estimate Option has the following fields:</p>
        <ul class="list-unstyled">
          <li><code class="me-1">string</code> Label</li>
          <ul><li>A unique label for each estimate</li></ul>
          <li><code class="me-1">string</code> Slug</li>
          <ul><li>Auto-generated based on the label and associated estimate's ID</li></ul>
          <li><code class="me-1">integer</code> Value</li>
          <ul><li>A numeric value for non-numeric or otherwise ambiguous labels</li></ul>
          <li><code class="me-1">integer</code> Sort Order</li>
          <ul><li>Order of the estimate options (configured via drag-and-drop)</li></ul>
        </ul>
        <p>An Estimate has the following relationships:</p>
        <ul class="list-unstyled">
          <li><code class="me-1">HasMany (1 <-> N)</code> Estimate Option</li>
          <ul><li>via <code>`estimate_options.estimate_id`</code></li></ul>
          <li><code class="me-1">HasMany (1 <-> 1)</code> Project</li>
          <ul><li>via <code>`projects.estimate_id`</code></li></ul>
        </ul>
        <p>An Estimate Option has the following relationships:</p>
        <ul class="list-unstyled mb-0">
          <li><code class="me-1">BelongsTo (1 <-> N)</code> Estimate</li>
          <ul><li>via <code>`estimate_options.estimate_id`</code></li></ul>
          <li><code class="me-1">HasMany (1 <-> 1)</code> Issue</li>
          <ul><li>via <code>`issues.estimate_option_id`</code></li></ul>
        </ul>
      </div>
    </div>
  </div>
</div>
