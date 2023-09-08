<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="nav nav-tabs nav-flush" role="tablist">
          <button class="nav-link active" id="nav-event-type-estimate-events-tab" data-bs-toggle="tab" data-bs-target="#nav-event-type-estimate-events" type="button" tabindex="-1">Events ({{ $eventType->events->count() }})</button>
        </div>
      </div>
      <div class="card-body mb-0">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade active show" id="nav-event-type-estimate-events" role="tabpanel" aria-labelledby="nav-event-type-estimate-events-tab">
            <table id="nav-event-type-events-table" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center mb-0">
              <thead>
                <tr>
                  <th class="th-min text-center">ID</th>
                  <th>Title</th>
                  <th>Recurrence</th>
                  <th class="th-affects-productivity text-center">Affects Productivity</th>
                  <th class="th-min text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($eventType->events as $event)
                  <tr>
                    <td class="td-min text-center">{{ $event->id }}</td>
                    <td>
                      <a href="{{ route('events.show', $event) }}">{{ $event->title }}</a>
                    </td>
                    <td>{{ $event->recurrence_display }}</td>
                    <td  class="td-affects-productivity text-center">
                      <i class="fa-solid fa-{{ $event->affects_productivity ? 'circle-check' : 'circle-xmark text-secondary' }}"></i>
                    </td>
                    <td class="td-min text-center">
                      <div class="btn-group">
                        @if($event->canEdit())
                          <a href="{{ route('events.edit', $event) }}" class="btn btn-link">
                            <i class="text-primary fa-regular fa-pen"></i>
                          </a>
                        @endif
                        <form action="{{ route('events.destroy', $event) }}" method="POST">
                          @method('DELETE')
                          @csrf
                          <button type="button" class="btn btn-link text-danger delete-event"><i class="text-danger fa-regular fa-trash"></i></button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5">
                      <i class="text-secondary">No connected Events...</i>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
