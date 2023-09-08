<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="nav nav-tabs nav-flush" role="tablist">
          <button class="nav-link active" id="nav-event-estimate-occurences-tab" data-bs-toggle="tab" data-bs-target="#nav-event-estimate-occurences" type="button" tabindex="-1">Occurences ({{ $event->occurences->count() }})</button>
        </div>
      </div>
      <div class="card-body mb-0">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade active show" id="nav-event-estimate-occurences" role="tabpanel" aria-labelledby="nav-event-estimate-occurences-tab">
            <table id="nav-event-occurences-table" class="table table-bordered table-striped {{ $theme->themeVar('table-dark', 'table-light') }} table-vertical-center mb-0">
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
                @forelse($event->occurences as $occurence)
                  <tr>
                    <td class="td-min text-center">
                      <a class="id-link" href="{{ route('occurences.show', $occurence) }}">{{ $occurence->id }}</a>
                    </td>
                    <td class="td-all-day text-center">
                      <i class="fa-solid fa-{{ $occurence->all_day ? 'circle-check' : 'circle-xmark text-secondary' }}"></i>
                    </td>
                    @if($occurence->all_day)
                      <td class="td-all-day-datetime" colspan="2">{!! $occurence->start_date_display !!}</td>
                    @else
                      <td class="td-start-datetime">{!! $occurence->start_date_time_display !!}</td>
                      <td class="td-end-datetime">{!! $occurence->end_date_time_display !!}</td>
                    @endif
                    <td class="td-duration text-center">{!! $occurence->duration_display !!}</td>
                    <td class="td-min text-center">
                      <div class="btn-group">
                        <a href="#" class="btn btn-link">
                          <i class="text-primary fa-regular fa-pen"></i>
                        </a>
                        <form action="#" method="POST">
                          @method('DELETE')
                          @csrf
                          <button type="button" class="btn btn-link text-danger delete-occurence"><i class="text-danger fa-regular fa-trash"></i></button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6">
                      <i class="text-secondary">No Event Occurences...</i>
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
