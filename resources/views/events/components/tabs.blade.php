<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="nav nav-tabs nav-flush" role="tablist">
          <button class="nav-link active" id="nav-event-estimate-occurrences-tab" data-bs-toggle="tab" data-bs-target="#nav-event-estimate-occurrences" type="button" tabindex="-1">Occurrences {!! $event->occurrences_count_display !!}</button>
        </div>
      </div>
      <div class="card-body mb-0">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade active show" id="nav-event-estimate-occurrences" role="tabpanel" aria-labelledby="nav-event-estimate-occurrences-tab">
            <table id="nav-event-occurrences-table" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center mb-0">
              <thead>
                <tr>
                  <th class="th-min text-center">ID</th>
                  <th class="th-all-day text-center">All Day</th>
                  <th class="th-start-datetime text-center">Start</th>
                  <th class="th-end-datetime text-center">End</th>
                  <th class="th-duration text-center">Duration</th>
                  <th class="th-min text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($event->occurrences as $occurrence)
                  <tr>
                    <td class="td-min text-center">
                      <a class="id-link" href="{{ route('occurrences.show', $occurrence) }}">{{ $occurrence->id }}</a>
                    </td>
                    <td class="td-all-day text-center">
                      <i class="fa-solid fa-{{ $occurrence->all_day ? 'circle-check' : 'circle-xmark text-secondary' }}"></i>
                    </td>
                    @if($occurrence->all_day)
                      <td class="td-all-day-datetime" colspan="2">{!! $occurrence->start_date_time_as_date_display !!}</td>
                    @else
                      <td class="td-start-datetime">{!! $occurrence->start_date_time_display !!}</td>
                      <td class="td-end-datetime">{!! $occurrence->end_date_time_display !!}</td>
                    @endif
                    <td class="td-duration text-center">{!! $occurrence->duration_display !!}</td>
                    <td class="td-min text-center">
                      <div class="btn-group">
                        <a href="{{ route('occurrences.edit', $occurrence) }}" class="btn btn-link">
                          <i class="text-primary fa-regular fa-pen"></i>
                        </a>
                        <form action="{{ route('occurrences.destroy', $occurrence) }}" method="POST">
                          @method('DELETE')
                          @csrf
                          <button type="button" class="btn btn-link text-danger delete-occurrence"><i class="text-danger fa-regular fa-trash"></i></button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6">
                      <i class="text-secondary">No Event Occurrences...</i>
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
